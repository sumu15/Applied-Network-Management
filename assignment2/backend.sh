#!/bin/bash
while true
do
start=`date +%s`
perl device.pl
perl server.pl
end=`date +%s`
runtime=$((end-start))
sleep $((60-runtime))
done

