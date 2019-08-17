#! /bin/sh

echo 'wp-config to 400'
chmod 400 application/data/nginx/wp-config.php

echo 'directories to 705'
find application/data/nginx -type d -exec chmod 705 {} +

echo 'files to 605'
find application/data/nginx -type f -exec chmod 605 {} +

echo 'complete!'












# original
#chmod 644 application/data/nginx/wp-config.php
#find application/data/nginx -type d -exec chmod 755 {} +
#find /path/to/dir -type f -exec chmod 644 {} +
