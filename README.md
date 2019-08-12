# docker-blog

Setup and Running Docker containers SSL dynamic proxy(Nginx) and WordPress.

## Requirements

* docker
* docker-compose

## Getting started

### Installation

Download the latest release of docker-blog.

```
$ cd /path/to/download
$ git clone https://github.com/ontheroadjp/docker-blog.git
```
### Settings

Copy ``path/to/download/docker-blog/application/bin/.env.example`` to the same directory as ``.env``.  
Edit ``.env`` file.  example below.

```bash
# ---------------------------------------------
# Application Settings
# ---------------------------------------------
APPLICATION_HOME=/path/to/download/docker-blog/application
UID=1000
GID=1000
```

```bash
# ---------------------------------------------
# Nginx(Web Server) settings
# ---------------------------------------------
SITE_URL=www.sample.com
LETSENCRYPT_EMAIL=sample@sample.com
PROXY_CACHE=true
```

```bash
# ---------------------------------------------
# DB settings
# ---------------------------------------------
DB_ROOT_PASSWORD=root
DB_NAME=wordpress
DB_USER=sakura
DB_PASSWORD=sakura_password
DB_TABLE_PREFIX=wp_
```

### Usage

#### Start Proxy Container
```bash
$ cd docker-blog/proxy/bin
$ docker-compose up -d
```

It will start three containers. Nginx, docker-gen and letsencrypt-nginx-proxy-companion container.

* Nginx: Proxy Server enabled the proxy cache
* docker-gen: Generate nginx conf files dynamically.
* letsencrypt-nginx-proxy-companion: create and update TLS cirtification.

#### Start WordPress Container
```bash
$ cd docker-blog/application/bin
$ docker-compose up -d
```

It will start three containers. Nginx, PHP-FPM and MariaDB container.

* Nginx: Web Server
* PHP-FPM: PHP-FPM module that is installed WordPress.
* MariaDB: Database for WordPress.

## License

* [jwilder/docker-gen](https://github.com/jwilder/docker-gen) - MIT
* [jwilder/docker-letsencrypt-nginx-proxy-companion](https://github.com/jwilder/docker-letsencrypt-nginx-proxy-companion) - MIT
