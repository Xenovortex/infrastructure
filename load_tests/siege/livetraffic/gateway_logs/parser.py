
#! /usr/bin/env python
import argparse
import sys
import re
import time

# 

line_nginx_full = re.compile(r"""(?P<ipaddress>\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}) - - \[(?P<dateandtime>\d{2}\/[a-z]{3}\/\d{4}:\d{2}:\d{2}:\d{2} (\+|\-)\d{4})\] ((\"(GET|POST) )(?P<url>.+)(http\/1\.1")) (?P<statuscode>\d{3}) (?P<bytessent>\d+) (["](?P<refferer>(\-)|(.+))["]) (["](?P<useragent>.+)["])""", 
    re.IGNORECASE)

line_nginx_onlyStatus = re.compile(r'.+HTTP\/1\.1" (?P<statuscode>\d{3})')
line_nginx_codeByMethod = re.compile(r'.+GET (?P<url>\/(?P<method>.+?)\?.+).+HTTP\/.+?" (?P<statuscode>\d{3})')

# based on redis-faina (https://github.com/Instagram/redis-faina)
class StatCounter(object):

    def __init__(self):
        self.line_count = 0
        self.skipped_lines = 0
        self.codes = {}
        self.line_re = line_nginx_codeByMethod
        self.file = open("tyk_api_urls.txt","w") 
        self.file.seek(0)
        self.file.truncate()
        self.URL = "URL=https://api.openrouteservice.org"
        self.file.write(self.URL + "\n")
        self.endpoints_mapping = {
            "routes": "directions",
            "/routes": "directions",
            "geocode": "geocoding",
            "pgeocoding": "geocoding",
            "isochrones": "isochrones",
            "pisochrones": "isochrones",
            "locations": "locations",
            "plocations": "locations",
            "matrix": "matrix",
            "pmatrix": "matrix",
            "corsdirections": "routes"
        }
        self.match_api_key = "api_key"
        self.api_key_unlimited = "58d904a497c67e00015b45fcacecf32dfe6248f4bd208bc3dc37e113"

    def _record_code(self, entry):
        code = entry['statuscode']
        method = entry['method']
        key = method + ' -> ' + code
        self.codes[key] = self.codes.get(key, 0) + 1


    def _general_stats(self):
        return (
            ("Lines Processed", self.line_count),
            ("Lines Skipped", self.skipped_lines),
        )

    def process_entry(self, entry):
        self._record_code(entry)

    def _pretty_print(self, result, title, percentages=False):
        print title
        print '=' * 40
        if not result:
            print 'n/a\n'
            return

        max_key_len = max((len(x[0]) for x in result))
        max_val_len = max((len(str(x[1])) for x in result))
        for key, val in result:
            key_padding = max(max_key_len - len(key), 0) * ' '
            if percentages:
                val_padding = max(max_val_len - len(str(val)), 0) * ' '
                val = '%s%s\t(%.2f%%)' % (val, val_padding, (float(val) / self.line_count) * 100)
            print key,key_padding,'\t',val
        print

    def _top_n(self, stat, n=8):
        sorted_items = sorted(stat.iteritems(), key = lambda x: x[1], reverse = True)
        return sorted_items[:n]

    def print_stats(self):
        self._pretty_print(self._general_stats(), 'Overall Stats')

        self._pretty_print(self._top_n(self.codes, n=100), 'Status codes', True)

    def process_input(self, input):
        for line in input:
            self.line_count += 1
            #if self.line_count >= 100:
            #    return

            line = line.strip()
            match = self.line_re.match(line)
            if not match:
                #print False, line
                if line != "OK":
                    self.skipped_lines += 1
                continue
            #print True, line
            match = match.groupdict()
            url = match["url"].replace(match["method"], self.endpoints_mapping[match["method"]])
            match["url"] = url
            
            api_key_idx_start = match["url"].find(self.match_api_key)+8
            api_key = url[api_key_idx_start:api_key_idx_start+56]

            url = match["url"].replace(api_key, self.api_key_unlimited)
            match["url"] = url

            self.file.write("$(URL)" + match["url"] + "\n") 

            self.process_entry(match)

if __name__ == '__main__':

    parser = argparse.ArgumentParser()
    parser.add_argument(
        'input',
        type = argparse.FileType('r'),
        default = sys.stdin,
        nargs = '?',
        help = "File to parse; will read from stdin otherwise")

    args = parser.parse_args()
    counter = StatCounter()
    start = time.time()
    counter.process_input(args.input)
    counter.print_stats()
    print 'Duration', time.time() - start
