# Installation of Goaccess

Some hints:

* install from source
* configure with `./configure --enable-utf8 --enable-geoip=mmdb --with-getline --with-openssl --enable-tcb=btree`, and install the missing deps when you meet errors
* download the GeoIP database file as prompted in the `goaccess.conf` which is located in `/usr/local/etc` if installed from source
* modify the `goaccess.conf`
* run the `start_goaccess_daemon.sh` script with root privilege
