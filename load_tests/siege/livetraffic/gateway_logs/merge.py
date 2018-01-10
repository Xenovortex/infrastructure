filenames = ['access.log.2','access.log.3','access.log.4','access.log.5','access.log.6','access.log.7','access.log.8','access.log.9','access.log.10','access.log.11','access.log.12','access.log.13','access.log.14']

with open('access_log_merged.txt', 'w') as outfile:
    for fname in filenames:
        with open(fname) as infile:
            for line in infile:
                outfile.write(line)