# Custom Kong/nginx config for performance optimization

## `ulimit`

It's very important to change the OS's default `ulimit -n` value (maximum number of opened file by one process) to increase Kong's concurrent processing capability. This value can be changed by running `$ ulimit -n <MAX_NUMBER>` **with the user who owns Kong process**. It's suggested by Kong's service that the `<MAX_NUMBER>` should be 4096 (default is 1024). However, 4096 is absolutely **not enough**. 65536 is a reasonable number. Besides, it's annoying to execute the command each time before start kong. So in practice, we do the optimization by modifying some files as follows. Please note that these are just examples. They should be adjusted according to the real systems' hardware/software environments.

### `sysctl.conf`

File excerpt: `/etc/sysctl.conf`

```
fs.file-max = 2097152
net.core.somaxconn = 65536
net.ipv4.tcp_max_tw_buckets = 1440000
net.ipv4.ip_local_port_range = 1024 65000
net.ipv4.tcp_fin_timeout = 15
net.ipv4.tcp_window_scaling = 1
net.ipv4.tcp_max_syn_backlog = 3240000
```

### `limits.conf`

File excerpt: `/etc/security/limits.conf`

```
root        hard        nofile        500000
root        soft        nofile        500000
```

### `custom_nginx.template`

Refer to the file under this directory. It contains some extra configs e.g. ssl session cache etc. that are not provided by Kong.
