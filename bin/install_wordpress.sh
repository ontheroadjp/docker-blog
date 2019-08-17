#! /bin/sh

wget https://wordpress.org/latest.tar.gz -P ../data/nginx/html && {
    tar xvzf wordpress-5.2.2.tar.gz
} && {
    mv ../data/nginx/html/wp-config.php ../data/nginx
} && {
    chmod 400 ../data/nginx/wp-config.php
    find ../data/nginx -type d -exec chmod 705 {} +
    find ../data/nginx -type f -exec chmod 605 {} +
}

echo 'complete!'












# original
#chmod 644 application/data/nginx/wp-config.php
#find application/data/nginx -type d -exec chmod 755 {} +
#find /path/to/dir -type f -exec chmod 644 {} +
