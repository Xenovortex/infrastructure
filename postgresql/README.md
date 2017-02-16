# Postgresql server config

## postgresql.conf

Change the `listen_address` value to `'*'`. This is a good practice in
administrating Postgresql. To fine-grained control the connection permissions,
modify the `pg_hba.conf` as follows.

## pg_hba.conf

Add a new config line (as follows) to allow all the connections from the other Kong cluster nodes within the same subnet.

```
# This is for accepting the connections from other Kong nodes within the same
subnet. CHANGE the IP addresses according to your own networking configs.
host    all             all             192.168.0.0/24          md5
# This is for accepting the connections from other Kong nodes running by
docker. CHANGE the IP addresses according to your own docker configs.
host    all             all             172.17.0.0/24           md5
```
