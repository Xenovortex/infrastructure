# To use coordinates for german postcodes we need:
# - the csv file from whosonfirst which tells us the file that the postcode is for
# - the txt file from geonmaes for the latitude and longitude

import zipfile
import csv
import json
import os.path

import sys
import argparse

# First we should load the csv and txt files into memory

dataPath = '/srv/data/pelias/'
country = 'DE'
wof_data = None
gn_data = None

# Check for system args and overwrite if needed
parser=argparse.ArgumentParser()
parser.add_argument('--path')
parser.add_argument('--country')

if len(sys.argv) > 0:
    args = parser.parse_args()
    if args.path:
        dataPath = args.path
    if args.country:
        country = args.country

with zipfile.ZipFile(dataPath + 'geonames/' + country + '.zip', 'r') as gnz:
    with gnz.open(country + '.txt', 'r') as f:
        reader = csv.reader(f, delimiter='\t')
        gn_data = list(reader)
        f.close()

csvpath = 'whosonfirst/meta/wof-postalcode-' + country.lower() + '-latest.csv'
if not os.path.isfile(dataPath + csvpath):
    print('No country csv, dropping back non-country file...')
    csvpath = 'whosonfirst/meta/wof-postalcode-latest.csv'
    if not os.path.isfile(dataPath + csvpath):
        print('Cannot open file {path}'.format(path=dataPath + csvpath))
        sys.exit()

with open(dataPath + csvpath) as f:
    reader = csv.reader(f, delimiter=',')
    wof_data = list(reader)
    f.close()
    
# The first row of the wof data is the header, so we should look in that to find the position of the 'name' column
namePos = 0
latPos = 0
lonPos = 0
pathPos = 0
latLabPos = 0
lonLabPos = 0
bboxPos = 0

cnt = 0
for col in wof_data[0]:
    if col == 'name':
        namePos = cnt
    if col == 'geom_latitude':
        latPos = cnt
    if col == 'geom_longitude':
        lonPos = cnt
    if col == 'path':
        pathPos = cnt
    if col == 'lbl_latitude':
        latLabPos = cnt
    if col == 'lbl_longitude':
        lonLabPos = cnt
    if col == 'bbox':
        bboxPos = cnt
    cnt+=1

# The geonames data does not contain headers, but we know that the postalcode is the second column
recCount = len(gn_data)
processed = 0
lastPerc = -1
changed = 0
for rec in gn_data:
    pc = rec[1]
    lat = rec[9]
    lon = rec[10]
    path = None
    # Find that postalcode in the wof csv
    for wofrec in wof_data:
        if wofrec[namePos] == pc and float(wofrec[latPos]) == 0.0 and float(wofrec[lonPos]) == 0.0:
            path = wofrec[pathPos]
            wofrec[latPos] = lat
            wofrec[lonPos] = lon
            wofrec[latLabPos] = lat
            wofrec[lonLabPos] = lon
            wofrec[bboxPos] = lon+','+lat+','+lon+','+lat
            changed += 1
            break
    
    #print path
    if path != None and lat != None and lon != None:
        # We need to open the file and then edit its contents
        #data = None
        with open(dataPath + 'whosonfirst/data/' + path, 'r+') as jsonfile:
            #print jsonfile
            data = json.load(jsonfile)
            # Update the coordinates
            data["properties"]["geom:latitude"] = lat
            data["properties"]["geom:longitude"] = lon
            data["properties"]["geom:bbox"] = lon+','+lat+','+lon+','+lat
            data["bbox"] = [lon,lat,lon,lat]
            data["geometry"]["coordinates"] = [lon, lat]
            
            #print(lat + ', ' + lon)
            # We have to leave the file and then overwrite it else we may end up with random data    
            jsonfile.seek(0)
            jsonfile.truncate()
            json.dump(data, jsonfile, sort_keys=True, indent=4, separators=(',', ':'), ensure_ascii=False)
            jsonfile.close()
    processed += 1
    perc = (processed/float(recCount)) * 100
    #print perc
    if int(perc)%5 == 0:
        if lastPerc != int(perc):
            lastPerc = int(perc)
            print('{perc}% complete...'.format(perc=int(perc)))

# Finally overwrite the wof csv file to reflect the updated coordinates
with open(dataPath + csvpath, 'r+') as f:
    f.seek(0)
    f.truncate()
    wr = csv.writer(f, quoting=csv.QUOTE_MINIMAL)
    wr.writerows(wof_data)
    f.close()

print('{recs} records modified'.format(recs=changed))