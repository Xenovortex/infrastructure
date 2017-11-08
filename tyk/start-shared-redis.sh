# Start shared redis on a standalone instance e.g. ors-placesdb-tykredisdb
docker run --name redis-tyk -p 6379:6379 -d redis
