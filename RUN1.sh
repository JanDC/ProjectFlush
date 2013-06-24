#!/bin/bash

folder=`echo $0 | sed -e 's/RUN1.sh//g'`
cd "$folder"
streamer -q -c /dev/video1 -o ramcache/wc1.jpeg
pbr=`php ret-brightness1.php`
echo $pbr > ramcache/brightness1
tstamp=`php log1.php`
echo $tstamp > ramcache/timestamp1
exit
