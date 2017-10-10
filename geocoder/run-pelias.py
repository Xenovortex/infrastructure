import time
import urllib2
import random
import numpy as np

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

# First we need to create random points within a bounding region
#bb = Polygon([(8.271,49.077),(8.771,49.077),(8.771,48.577),(8.271,48.577)])
bb = Polygon([(-180,-180),(180,-180),(180,180),(-180,180)])
locs = random_points_within(bb,n_locs)

total_time = 0
count = 0
all_start = int(round(time.time() * 1000))
# Now run the request for each point and store the time taken to complete
for loc in locs:    
    url = "http://" + address + ":" + str(port) + "/v1/reverse?point.lon=" + str(loc.x) + "&point.lat=" + str(loc.y)
    start = int(round(time.time() * 1000))
    nf = urllib2.urlopen(url)
    page = nf.read()
    nf.close()
    end = int(round(time.time() * 1000))
    #print(str(start) + " " + str(end))
    duration = end-start
    total_time = total_time + duration
    count = count + 1
    if count%100 == 0:
        print(str(count) + "... " + url)

print("average time from " + str(n_locs) + " reverse geocode requests: " + str(total_time/n_locs) + "ms")
