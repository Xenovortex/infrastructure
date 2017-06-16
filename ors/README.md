# ORS core

## Prequisite software 

To install OpenRouteService on a Linux server (preferably ubuntu) following software packages are required:

- [Docker CE](https://docs.docker.com/engine/installation/linux/ubuntu/#install-using-the-repository)
- [Docker compose](https://docs.docker.com/compose/install/)
- Please increase the `vm.max_map_count` setting [How?](https://ynuxtechblog.wordpress.com/2016/01/05/getting-your-system-parameters-right-in-dockered-elasticsearch/#vm.max_map_count)

## Folder structure

The root folder here is `webfrastructure`, the naming however is arbitary. Within this directory you will find the `docker-compose.yml` file. This file
controls Java and Tomcat Catalina options and shared volumes. Nothing must be changed here except the path of your pbf file for graph generation ` - /path/to/pbf/file.pbf:/home/data/`
as well as the `Xmx` setting for the Java heap.   

Within `webfrastructure` are two subfolders, dockerfiles and tomcat. 

The folder `dockerfiles` should stay unchanged and contains the tomcat docker image and jmx tool which is installed by default. 
	
Within the folder `tomcat` lies the `ors.war` application. The subfolder `conf` contains `app.config` which controls the spatial coverage and graph profiles of the service. 
The name of your pbf source file has to be defined witin this config file. The computes graphs are saved in `data/graphs`.
On other file you will find here is `server.xml` which is used to disable tomcat access logging. Both folders `logs` and `ors-logs` are created as shared
volumes by docker on launch. The former contains tomcat logging and the latter logs directly from the openrouteservice application itself.

```webfrastructure/
|-- dockerfiles
|   `-- tomcat
`-- tomcat
    |-- conf
    |-- data (created by container)
    |   `-- graphs
    |-- logs (created by container)
    `-- ors-logs (created by container)```

## Steps to run

To create the docker container we use docker-compose. Browse to your root folder after making the necessary config adaptions and start the container with

`sudo docker-compose up -d`

This command will create the containers and start the tomcat instance. The `app.config` file must be copied into the container after it has is started.

`sudo docker cp path/to/app.config ors-app:/usr/local/tomcat/webapps/ors/WEB-INF`

Aftwards the container must be restarted again with `sudo docker restart ors-app`.
