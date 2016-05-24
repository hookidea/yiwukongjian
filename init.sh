#!/bin/bash
#

rm -rf `ls | egrep -v "(Uploads|201*)"`

tar -xjf 201*.tar.bz2 .


chmod -R 777 ./Application/Runtime
rm -rf ./Application/Runtime/*

chmod -R 777 ./Wap/Runtime
rm -rf ./Wap/Runtime/*

chmod -R 777 ./Uploads/
chmod -R 777 ./Public/

chown apache:apache ./Application/Common/Conf/config.php
chown apache:apache ./Wap/Common/Conf/config.php

rm -rf 201*.tar.bz2
