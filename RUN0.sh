#!/bin/bash

folder=`echo $0 | sed -e 's/RUN0.sh//g'`
cd "$folder"
streamer -q -c /dev/video0 -o wc0.jpeg
pbr=`php ret-brightness0.php`
echo $pbr > brightness0
tstamp=`php log0.php`
echo $tstamp > timestamp0
exit
