#!/bin/bash

folder=`echo $0 | sed -e 's/RUN1.sh//g'`
cd "$folder"
streamer -q -c /dev/video1 -o wc1.jpeg
pbr=`php ret-brightness1.php`
echo $pbr > brightness1
tstamp=`php log1.php`
echo $tstamp > timestamp1
exit
