#!/bin/bash

# set MTU according to URZ
echo "post-up /sbin/ip link set dev ens3 mtu 1500" >> /etc/network/interfaces.d/50-cloud-init.cfg
# Add google nameservers
echo "dns-nameservers 8.8.8.8 8.8.4.4" >> /etc/network/interfaces.d/50-cloud-init.cfg
ifdown ens3 && ifup ens3

# Add hostname
sed -i "1s/.*/127.0.0.1 localhost $HOSTNAME/" /etc/hosts

# Install docker
apt-get update
apt-get install -y \
    apt-transport-https \
    ca-certificates \
    curl \
    software-properties-common

curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
apt-key fingerprint 0EBFCD88

add-apt-repository \
   "deb [arch=amd64] https://download.docker.com/linux/ubuntu \
   $(lsb_release -cs) \
   stable"
apt-get update
apt-get install -y docker-ce

# Install docker-compose
chmod -R 777 /usr/local/bin
curl -L https://github.com/docker/compose/releases/download/1.11.2/docker-compose-Linux-x86_64 -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose

# Install misc
apt-get install -y tree

# Install pip
apt-add-repository ppa:ansible/ansible
apt-get update
apt-get install -y python-pip \
    ansible

exit 0