Setting up Pelias to run comprises of several stages. These are
1. Seting up the servers
2. Installing ElasticSearch onto a cluster
3. Setting up the ElasticSearch server environments for Pelias optimisation
4. Downloading and setting up the Pelias modules
5. Downloading and importing data into the ElasticSearch database

## Initial Server Setup
On any new servers from the HeiCloud, a few initial setup processes are needed.

### Allowing Internet Connection

On new server instances from HeiCloud, you need to enable external internet connection. For that add the following lines to the config file found at /etc/network/interfaces.d/50-cloud-init.cfg

	dns-nameservers 8.8.8.8 8.8.4.4
	dns-search google.com

after checging you need to restart the network interface, either via a reboot or using the command

	sudo ifdown ens3 && sudo ifup ens3

### Install Java

ElasticSearch requires at least Java 7 to run, so you need to make sure that this is installed on the system. run the command 
	
	java -version

to see if it is installed. If not, then you need to install an appropriate version of Java. For example

	sudo apt-get install default-jdk

## Installing ElasticSearch

ElasticSearch needs installing on each of the servers that will become nodes in the cluster.

Though ElasticSearch is now at version 5.x, Pelias only supports version 2.4.x and so you need to make sure that that is the version that you install. You can either install from a tar file, or using apt-get. All installation instructions can be found at https://www.elastic.co/guide/en/elasticsearch/reference/2.4/_installation.html. 

For using apt-get, detailed instructions can be found at https://www.elastic.co/guide/en/elasticsearch/reference/2.4/setup-repositories.html. You need to first get the Public Signing Key for the repository using the command

	wget -qO - https://packages.elastic.co/GPG-KEY-elasticsearch | sudo apt-key add -

Next you need to tell apt that it should look for ElasticSearch in the correct repository using the command

	echo "deb https://packages.elastic.co/elasticsearch/2.x/debian stable main" | sudo tee -a /etc/apt/sources.list.d/elasticsearch-2.x.list

Now that Ubuntu know where to look, you can install ElasticSearch using the command
	
	sudo apt-get update && sudo apt-get install elasticsearch

Finally, you need to tell Ubuntu to start the ElasticSearch service at bootup. To do that, enter the commands
	
	sudo /bin/systemctl daemon-reload
	sudo /bin/systemctl enable elasticsearch.service
	sudo systemctl restart elasticsearch.service

ElasticSearch should now be running on the server. To check you can simply use the command
	
	curl http://localhost:9200

which should give you a response similar to 

	{
	  "name" : "Plague",
	  "cluster_name" : "elasticsearch",
	  "cluster_uuid" : "UT1FQ8-5TcSfVxHPPOzEow",
	  "version" : {
	    "number" : "2.4.5",
	    "build_hash" : "c849dd13904f53e63e88efc33b2ceeda0b6a1276",
	    "build_timestamp" : "2017-04-24T16:18:17Z",
	    "build_snapshot" : false,
	    "lucene_version" : "5.5.4"
	  },
	  "tagline" : "You Know, for Search"
	}


## Setting Up ElasticSearch

ElasticSearch normally works straight out of the box, but there are several things that need changing on the server and within the ElasticSearch configurations for it to work properly with Pelias. The first thing to change is the number of open file descriptors available on the system. by default this is very low (around 1000) and should be increased. To check how many are available, enter
	
	ulimit -n

If this is below 65536, it is likely not going to be enough for ES. To update this, you need to make a couple of changes. Be warned though, check that you have entered information correctly as entering it wrong can result in a bricked server! In the file /etc/security/limits.conf you need to enter the following information

	*	    soft	nofile	65536
	*	    hard	nofile	65536
	root	soft	nofile	65536
	root	hard	nofile	65536

Now you need to tell Ubuntu to use these values whenever a user logs in. in the files /etc/pam.d/common-session and /etc/pam.d/common-session-noninteractive you need to make sure that the following line exists

	session	required	pam_limits.so

After changing, log out of the server and then log back in to apply changes. running the ulimit -n command again should now show 65536.

ES also uses mmapped files, and so you need to edit the /etc/sysctl.conf file to add the following line

	vm.max_map_count = 262144

A final system setting that needs to be updated is to stop the system performing memory swapping as this massively slows down performance. This is doen permanently by adding the following line to the /etc/systctl.conf file

	vm.swappiness = 1

Afterwards, reboot the system and swapping should only happen when absolutely essential.

The other changes that are needed are made within the ElasticSearch config settings. These can be found in the /etc/elasticsearch/elasticsearch.yml file. The main ones that need updating are the node name and the cluster name. For each node in the cluster, the cluster should be the same (i.e. cluster.name: ors-pelias-es) and the node name should be unique (i.e. node.name: ors-pelias-es-n1). IMPORTANT: DO NOT USE TABS INSIDE THE YML FILE, ONLY SPACES!

To ensure that the service nows properly how to talk to other nodes, you should update the network.host setting to be the same as the ip of the current server, i.e.

	network.host: 192.168.2.36

You also need to tell ES where it can find the other nodes that are on the cluster. This is set by providing the list of ip addresses for the other nodes:

	discovery.zen.ping.unicast.hosts: ["192.168.2.37", "192.168.2.38", "192.168.2.39"]

Note that you shouldn't put in the ip address of the node that you are currently configuring, only the others.

For security reasons, you should also add the line

	discovery.zen.ping.multicast.enabled: false

As mentioned in their configuration documentation, you should also change the paths for data and logs to a different location than the default. By default, the paths point to the installation directory, but an update to ES could cause these paths to be deleted, thus deleting all data in the system. A good alternative is to set the following:
	
	path.data: /srv/elasticsearch/data
	path.logs: /srv/elasticsearch/log

Note that if they don't exist, then you should create the folders (and remember to set permissions so that the folders can be read by the user/service running elasticsearch using ´sudo chown -R elasticsearch /srv/elasticsearch´).

Another setting that is important to the overall stability of the cluster is the minimum_master_nodes setting. Basically, a master node is the node that defines items such as creating new indices, moving shards etc. In some instances, it could be possible for ES to designate 2 master nodes, which would cause problems (if the original master node goes offline for some reason, then a new master is elected). When a new master is created, it is 'elected' by the other nodes, and so a quorum must be reached. To make sure that the correct quorum is reached, then the minimum_master_nodes should be set. The quorum is calculated using the formula
	
	(no. of master-elegible nodes / 2) + 1

So in the case of 4 nodes, the quorum would be 

	(4 / 2) + 1 = 3

so the setting is

	discovery.zen.minimum_master_nodes: 3

When a node (or more) in the cluster goes down, ES attempts to distribute shards amongst the remaining nodes equally. If the down time is for only a short period (i.e. a system reboot), we do not want the reallocation to take place (if the node comes back online and sees that its data has been 'moved' to other nodes, it would delete all of its data as it may be out of date and then the cluster would reallocate the shards across the whole cluster to rebalance. Obviously in large databases this could take considerable time. What we want to do is tell ES that it should only perform this rebalancing when a specific number of nodes are available. Until this number of nodes is available on the cluster, no recovery will take place and the whole service will be inoperable. Though this sounds bad, it is likely better for the whole service to be unavialable for a short time and then be back up and running rather than slowing down considerably for what could be hours. For now, an appropriate setting for this is

	gateway.recover_after_nodes: 3

As mentioned just, we probably don't want the service to freak out if a single node is being rebooted. Using the previous setting, the service will only recover if a minimum of 3 nodes are available. However, a quick reboot will cause this scenario to be met and so the recovery will begin. To stop this happening ES can be told to wait for a specific time before doing the recovery. If an expected number of nodes is not reached after a certain time, then the recovery will begin. These settings are:

	gateway.expected_nodes:	4
	gateway.recover_after_time: 5m

This tells ES that there should be 4 nodes in the cluster, and to begin recovery after 5 minutes if there are still not 4 nodes. IMPORTANT: THE RECOVERY PROCESS CAN ONLY BE COMPLETED IF REPLICA SHARDS ARE AVAILABLE!

The final item needed for pelias is a unicode plugin for elasticsearch. This is installed by going to the ES home folder (/usr/share/elasticsearch) and running the command

	sudo bin/plugin install analysis-icu

ES uses a lot of heap storage for handling indexes and searching, and by default it comes set to 1GB which is massively too low. Though instructions for installation from ElasticSearch tell you to set an environment variable for altering the heap size, this does not work. Instead you need to edit the settings file at /etc/default/elasticsearch and add the line

	ES_HEAP_SIZE=16g

After that, restart the node and the new heap size should take effect.	
	
### Installing Monitoring software (Marvel)

Marvel is a plugin for elasticsearch that allows you to view the status of the cluster. To install it, navigate to the ES home directory (/usr/share/elasticsearch) and run the commands

	sudo bin/plugin install license
	sudo bin/plugin install marvel-agent

## Installing Pelias

Pelias is a modular geocoder running through node.js. All modules for pelias are downloaded from github and run via npm commands.

Before installing anything from pelias, yoiu need to install libpostal on the server. Though it is "optional" many things (including some installs) wont work without it. First install prerequisits with

	sudo apt-get install curl autoconf automake libtool pkg-config

Then you need to install the C library itself (note you will likely need to create the libpostal-data folder and allow access to it)
	
	git clone https://github.com/openvenues/libpostal
	cd libpostal
	./bootstrap.sh
	./configure --datadir=/srv/libpostal-data
	make
	sudo make install
	sudo ldconfig

To run and install Pelias, you need to have NodeJS installed. To do that, you need to run:
    
    sudo apt-get update
    sudo apt-get install nodejs
    sudo apt-get install npm

When using pelias, it is important to decide which data will be used in the geocoder. In our case we use openstreetmap, polylines and whosonfirst.

The first stage is to download the repositories for the components from github. For this, you need to run the following commands, changing [module] for values of schema, api, whosonfirst, openstreetmap, and polylines.

	git clone https://github.com/pelias/[module].git
	cd [module]
	git checkout production
	npm install
	cd ..

Once these are installed, you need to get the config data. All of the pelias modules get settings from a pelias.json file that is housed in the home directory of the user running the process. The pelias.json config file should contain

    {
        "esclient": {
            "hosts": [
                {
                    "host":	"192.168.2.36",
                    "port":	9200
                }, {
                    "host": "192.168.2.37",
                    "port": 9200
                }, {
                    "host": "192.168.2.38",
                    "port": 9200
                }, {
                    "host": "192.168.2.39",
                    "port": 9200
                }
            ]
        }, 
        "elasticsearch": {
            "settings": {
            "index": {
                "number_of_replicas": "0",
                "number_of_shards": "24",
                "refresh_interval": "1m"
            }
            }
         },
        "schema": {
            "indexName": "pelias"
        },
        "api": {
            "textAnalyzer": "libpostal",
            "indexName": "pelias",
            "version": "1.0",
            "host": "129.206.7.154"
        },
        "imports": {
            "adminLookup": {
                "enabled": true,
                "maxConcurrentRequests": 1000
            },
            "openstreetmap": {
                "datapath": "/home/pelias/data/openstreetmap",
                "leveldbpath": "/home/pelias/tmp/osm",
                "import": [
                    { "filename": "planet.osm.pbf" }
                ]
            },
            "whosonfirst": {
                "datapath": "/home/pelias/data/whosonfirst",
                "importVenues": false,
                "importPostalcodes": true,
                "missingFilesAreFatal: true
            },
            "polyline": {
                "datapath": "/home/pelias/data/polylines",
                "files": ["road_network.polylines"]
            }
        }
    }

Obviously, the elasticsearch settings and datapaths/filenames should be modified to reflect actual values.

## Downloading and Importing Data
Once the modules are ready on the importer server, relevant data for each module needs downloading and then the module can import this into the ES database. Though technically multiple imports can be done at once, this can put a lot of strain on the ES cluster and so it may be better to stick to one at a time until it is fully tested.

### WhosOnFirst

The main reason for using WhosOnFirst is to obtain administration areas and postcodes, and also to associate this information to other features imported (i.e. OSM data).

The first step is to download the data. This is done within the whosonfirst folder using 
	
	npm run download

When the process has completed, check to see if there were any errors with downloading the postalcode data. If there was, then these files need to be downloaded and extracted manually. For those that don't work, you need to run the following commands, replacing the wof-postalcode-nl-latest-bundle.tar.bz2 filename with the file that didn't work

	wget https://whosonfirst.mapzen.com/bundles/wof-postalcode-nl-latest-bundle.tar.bz2
	tar -xjf wof-postalcode-nl-latest-bundle.tar.bz2 --strip-components=1 --exclude=README.txt -C /home/pelias/data/whosonfirst
	mv /home/pelias/data/whosonfirst/wof-postalcode-nl-latest.csv /home/pelias/data/whosonfirst/meta
	rm wof-postalcode-nl-latest-bundle.tar.bz2
	
Once all the data has been downloaded, it can be used by other importaers to add the administrative boundary information to features. We will here also import the data into the ES database so that it is avilable from searches. To do that, you simply need to run the command 
    
    npm start

which will begin the import process. It is better to run this as a background process so that closing the connection does not stop the process. The best way of doing this is to create a .service file which can then be run using the systemctl command. For the whosonfirst import, the .service file should be along the lines of

    [Unit]
    Description=Pelias WhosOnFirst Importer
    
    [Service]
    WorkingDirectory=/home/pelias/whosonfirst
    ExecStart=/usr/bin/npm start
    Environment=NODE_ENV=production
    User=pelias
    Restart=no
    
    [Install]
    WantedBy=multi-user.target

and added to the /etc/system/systemd/ folder. Once added, reload the daemon using

    sudo systemctl daemon-reload

and then start the service via

    sudo systemctl restart pelias-whosonfirst-importer.service
    
A similar import process should be created for each of the import modules used in Pelias.

### Polylines

Polylines data is used to import streets into the Pelias database. Further instructions for installation can be found at https://github.com/pelias/polylines.

The first thing to do for importaing polylines is to download the data. A full planet database can be obtained from http://missinglink.files.s3.amazonaws.com/road_network.gz and measure around 1.5Gb. Once downloaded, extract it to the location defined by the `datapath` parameter under `polylines` within the pelias.json config file. The command used for extraction is

    gunzip road_network.gz
    mv road_network road_network.polylines

Next, create a service file similar to the whosonfirst service, and follow the same steps to activate and run it.

### OpenStreetMap

To import the OSM data into Pelias you first need to download the planet file. See http://wiki.openstreetmap.org/wiki/Planet.osm#Downloading for a list of possible download locations, and then wget the file into the location defined by the `datapath` parameter under `openstreetmap` within the pelias.json config file.

Again, create the service file as with other importers and start it to begin the import process
	