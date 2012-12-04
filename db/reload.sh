#!/bin/bash
DIR="$(dirname "${BASH_SOURCE[0]}")"
cd $DIR
mysql --user=$MYSQL_USER --password=$MYSQL_PASSWORD < reload.sql
