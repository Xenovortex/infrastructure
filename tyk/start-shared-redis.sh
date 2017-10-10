# For creating a specific network interface 'tyk-network'
docker network create tyk-network
# Start shared redis with 'tyk-network'
docker run --name redis-tyk --network tyk-network -p 6379:6379 -d redis
