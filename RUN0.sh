#!/bin/bash

folder=`echo $0 | sed -e 's/RUN0.sh//g'`
cd "$folder"
streamer -q -c /dev/video0 -o ramcache/wc0.jpeg
pbr=`php ret-brightness0.php`
echo $pbr > ramcache/brightness0
tstamp=`php log0.php`
echo $tstamp > ramcache/timestamp0
exit
