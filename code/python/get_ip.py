#!/usr/bin/env python3
import subprocess
import re

(status, output) = subprocess.getstatusoutput('ifconfig')
if status == 0:
    pattern = re.compile('en0' + '.*?inet.*?(\d+\.\d+\.\d+\.\d+).*?netmask', re.S)
    result = re.search(pattern, output)
    if result:
        ip = result.group(1)
        print(ip)


