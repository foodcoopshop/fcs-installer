#!/bin/bash
./Vendor/bin/phar-composer build ./webroot/ ./webroot.phar
cp webroot.phar latest/fcs-installer.php
cp webroot/index.php latest/