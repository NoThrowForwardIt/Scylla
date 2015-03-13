#!/usr/bin/env python
import sys

### DIARIOSEC GROUP ###
### B3RG & IRONBITS ###
### www.Ironbits.me ###

try:
    import requests
except Exception:
    print "You don't have 'requests' library installed. Please run 'easy_install requests' as root to install it."
    sys.exit(1)

url = sys.argv[1]
if url.count("http://") <> 1:
    url = "http://"+url

if len(sys.argv) == 3:
    print ""
    print "====== Requesting to %s ======" %(url)
    print ""
    f = open(sys.argv[2])
    for path in f:
        request = requests.get(url+path)
        if request.status_code == 200:
            print path
    print ""
    print "====== End requesting to %s ======" %(url)
    print ""
else:
    print "Usage: path_request.py "

sys.exit(0)
