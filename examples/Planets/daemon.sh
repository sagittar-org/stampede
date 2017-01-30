#!/bin/sh
inotifywait -e create,delete,modify,move -m -r input ../../bin | while read line; do echo $line; make; done;
