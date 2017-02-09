# Postgresql server config

## postgresql.conf

Change the `listen_address` value to `'*'`

## pg_hba.conf

Add a new config line (as follows) to allow all the connections from the other Kong cluster nodes within the same subnet.

```
host    all             all             192.168.0.0/24          md5
```
