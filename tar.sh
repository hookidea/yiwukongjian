#!/bin/bash

datename=$(date +%Y%m%d%H%I%s)

tar -cjf $datename.tar.bz2 ./* --exclude=./Uploads --exclude="[0-9]*"
