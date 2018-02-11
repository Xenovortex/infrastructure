## Processing GeoTif

#### Download GeoTif
```bash
wget http://cidportal.jrc.ec.europa.eu/ftp/jrc-opendata/GHSL/GHS_POP_GPW4_GLOBE_R2015A/GHS_POP_GPW42015_GLOBE_R2015A_54009_250/V1-0/GHS_POP_GPW42015_GLOBE_R2015A_54009_250_v1_0.zip

unzip GHS_POP_GPW42015_GLOBE_R2015A_54009_250_v1_0.zip -d ./
cd ./GHS_POP_GPW42015_GLOBE_R2015A_54009_250_v1_0
```


#### Clip sub-region around Rotterdam (can be skipped)
Only do this to quickly test, if everything works. Note, you'll have to modify all file names in the following instructions, in case you do clip.

```bash
cd ./raster
gdalwarp -cutline ./../shp/Clip_Rotterdam_ESRI54009.shp -crop_to_cutline /path/to/GHS_POP_GPW42015_GLOBE_R2015A_54009_250_v1_0.tif GHS_Rotterdam.tif 
```


#### Set nodata value to 0

The original nodata value is not present in the dataset AFAIK. Setting it to `0` ensures optimal spatial query behaviour.

```bash
gdal_translate -a_nodata 0 -co COMPRESS=LZW -co TILED=YES --config GDAL_CACHEMAX 500 GHS_POP_GPW42015_GLOBE_R2015A_54009_250_v1_0.tif GHS_POP_2015_ESRI54009_masked.tif
```

- `-a_nodata`: Assing nodata value to output raster. Makes sure oceans etc are nodata.
- `co`: Extra options for selected driver. In this case, [GTiff](http://www.gdal.org/frmt_gtiff.html).
- `--config`: Not sure where those parameters come from. Setting `GDAL_CACHEMAX` assigns cache for GDAL, used to improve speed.

#### Insert ESRI:54009 to PostgreSQL

For a final insertion to PostgreSQL, you'll need to manually register the CRS with `spatial_ref_sys`:

```bash
sudo -u user psql
```
```sql
INSERT into spatial_ref_sys (srid, auth_name, auth_srid, proj4text, srtext) 
values ( 954009, 
		'esri', 
		54009, 
		'+proj=moll +lon_0=0 +x_0=0 +y_0=0 +ellps=WGS84 +datum=WGS84 +units=m +no_defs ', 
		'PROJCS["World_Mollweide",GEOGCS["GCS_WGS_1984",DATUM["WGS_1984",SPHEROID["WGS_1984",6378137,298.257223563]],PRIMEM["Greenwich",0],UNIT["Degree",0.017453292519943295]],PROJECTION["Mollweide"],PARAMETER["False_Easting",0],PARAMETER["False_Northing",0],PARAMETER["Central_Meridian",0],UNIT["Meter",1],AUTHORITY["EPSG","54009"]]'
		);
```

#### Reproject raster (can be skipped)

Not recommended. The original comes in ESRI54009 (aka Mollweide) and as such is equal-area. Rather transform the query polygons from 4326 to 54009.

If really desired, this is the workflow.

First, download the .prj file, since it's not an official EPSG SRID:

```bash
wget -O ./54009.prj https://epsg.io/54009.wkt?download
```

Reproject:

```bash
gdalwarp -srcnodata 0 -dstnodata 0 -wo INIT_DEST=0 -co COMPRESS=LZW -co TILED=YES --config GDAL_CACHEMAX 500 -s_srs '/home/nilsnolde/dev/python/openrouteservice-tools/ghs_population_grid/raster/54009.prj' -t_srs 'EPSG:4326' GHS_POP_2015_ESRI54009_masked.tif GHS_POP_2015_EPSG4326_masked.tif 
```

- `-srcnodata`: The nodata value of the source raster.
- `-dstnodata`: The nodata value for the output raster.
- `co`: Extra options for selected driver. In this case, [GTiff](http://www.gdal.org/structGDALWarpOptions.html#a0ed77f9917bb96c7a9aabd73d4d06e08).
- `-s_srs`: Source CRS, here defined via the .prj file.
- `t_srs`: Output CRS, here defined via EPSG code.

In the following step, just replace the input filenames with the transformed one.

#### Raster to PostGIS
```bash
raster2pgsql -s 954009 -t 128x128 -b 1 -P -I -C -F ./GHS_POP_2015_ESRI54009_masked.tif public.ghs_pop_2015_esri54009 | psql -d nilsnolde
```

- `-s`: CRS SRID of raster. Note, that the SRID is **9**54009, as per `INSERT` statement above.
- `-t`: Tile size in pixels `Width`x`Height`.
- `-b`: Raster band to be considered.
- `-P`: Pad right-most and bottom-most tiles to guarantee that all tiles have the same width and height.
- `-I`: Create GIST index on rast column.
- `-C`: Apply raster constraints. Important!
- `-F`: Adds a filename column to the raster table.


#### Simple query
```sql
SELECT ROUND(SUM((ST_SummaryStats(ST_Clip(rast,poly))).sum))
FROM ghs_pop_2015_esri54009,
   	 ST_Transform(ST_GeomFromText('Polygon ((4.3606 52.1178, 4.3567 52.0227, 4.2906 52.0584, 4.3606 52.1178))', 4326), 954009)  as poly
WHERE ST_Intersects(poly,rast);
```
