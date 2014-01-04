#!/bin/bash

data=gaslog.json
database=gaslog


old_IFS=$IFS
IFS=$'\n'

regex_json_line="^\{.*\},?$"
for i in $(cat $data); do
  if [[ $i =~ $regex_json_line ]]; then
    document=$(echo $i | sed "s/,$//")
    uuid=$(curl -s -X GET http://localhost:5984/_uuids | cut -d\" -f4)
    echo $uuid
		echo $document
    eval curl -X PUT http://localhost:5984/gaslog/$uuid -d \'$document\'
  fi
done
IFS=$old_IFS
