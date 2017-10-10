# Custom rules for ORS Directions API

This is a description of the rules applied on Directions API. The structured
expression of these rules is stored in `rules.json` file. Rules can be defined
at both policy and key levels.

## Policy-level rules

### Free

#### Available profiles

*Note*: by default, all profiles are available if this section is blank. 

As an example, all profiles are listed here:

 - driving-car 
 - driving-hgv 
 - cycling-regular 
 - cycling-road 
 - cycling-safe 
 - cycling-mountain 
 - cycling-tour 
 - cycling-electric 
 - foot-walking 
 - foot-hiking 
 - wheelchair

#### Distance limits

Distance limit checking is based on the sum of geodetic distances between each
neighboured waypoints specified by `coordinates` parameter in the
querystring for each request. Distance limit rules can be defined for each
valid profile separately. The unit of distance limit is `km`.

*Note*: by default, the distance limit for a profile is unlimit if this profile is
valid in `available profiles` but not explictly defined in this section.

 - driving-car: 500
 - foot-walking: 100

#### Geoextent limits

Geoextent limits define the valid bounding box for routing requests. By
default, it's the whole world if left as blank. A sample geoextent limit for
Germany:

 - minx: 5.98865807458
 - miny: 47.3024876979
 - maxx: 15.0169958839
 - maxy: 54.983104153
 - name (optional): Germany

### Standard

### Basic

### Premium

### OnlyForPublicInstance

### Internal test

## Key-level rules

Rules can be defined for a specific key as well. And this level of rule will
override that in the policy-level if there are conflicts. However, it's not
recommanded to define rules at this level. Use policy-level rules as much as
possible.
