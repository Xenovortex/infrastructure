import time
import urllib2
import urllib
import random
import numpy as np
import json

from shapely.geometry import Polygon, Point

def random_points_within(poly, num_points):
    min_x, min_y, max_x, max_y = poly.bounds
    
    points = []
    
    while len(points) < num_points:
        random_point = Point([random.uniform(min_x, max_x), random.uniform(min_y, max_y)])
        if(random_point.within(poly)):
            points.append(random_point)
        
    return points

n_locs = 1000
port = 3100
address = "129.206.7.154"
locs = []
names = []

# First we need to create random points within a bounding region
bb = Polygon([(8.271,49.077),(8.771,49.077),(8.771,48.577),(8.271,48.577)])
#bb = Polygon([(-180,-180),(180,-180),(180,180),(-180,180)])
locs = random_points_within(bb,n_locs)

# Now run the request for each point and store the time taken to complete
for loc in locs:    
    url = "http://" + address + ":" + str(port) + "/v1/reverse?point.lon=" + str(loc.x) + "&point.lat=" + str(loc.y)
    
    nf = urllib2.urlopen(url)
    page = nf.read()
    nf.close()
    end = int(round(time.time() * 1000))
    #print(str(start) + " " + str(end))
    
    # Output the result
    pageJson = json.loads(page)

    if pageJson["features"] and pageJson["features"][0]:
        n = pageJson["features"][0]["properties"]["name"]

        names.append(str(n.encode('utf-8')))
    #print(json.load(page))

print ("Obtained " + str(len(names)) + " locations.")
# now run through the names that were found and do normal geocoding

total_time = 0
count = 0
all_start = int(round(time.time() * 1000))
print ("STarted at " + str(all_start))
for add in names:
    url = "http://" + address + ":" + str(port) + "/v1/search?text=" + urllib.quote(add)

    start = int(round(time.time() * 1000))
    nf = urllib2.urlopen(url)
    page = nf.read()
    nf.close()
    end = int(round(time.time() * 1000))

    duration = end-start
    total_time = total_time + duration
    count = count + 1
    if count%100 == 0:
        print(str(count) + "... " + url)

end_time = int(round(time.time() * 1000))
print("Ended at " + str(end_time))
print("Total " + str(end_time - all_start))
print("average time from " + str(len(names)) + " geocode requests: " + str(total_time/len(names)) + "ms")

