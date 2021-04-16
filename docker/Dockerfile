ARG PHP_VERSION=7.4
FROM php:${PHP_VERSION}-fpm

WORKDIR /tmp

RUN set -eux; \
	apt-get update -yq; \
	apt-get install -yq \
		gnupg; \
	echo "deb https://packages.sury.org/php/ buster main" >> /etc/apt/sources.list; \
	curl -fsSL https://packages.sury.org/php/apt.gpg | apt-key add -; \
	apt-get update -yq; \
	apt-get install -yq \
		git \
		libzip-dev; \
	pecl install \
		zip

ENV PHP_HOME=/usr/local

RUN set -eux; \
	git clone --depth 1 https://github.com/snowflakedb/pdo_snowflake.git; \
	cd pdo_snowflake; \
	bash scripts/build_pdo_snowflake.sh; \
	cp modules/pdo_snowflake.so /usr/local/lib/php/extensions/no-debug-non-zts-20190902/; \
	cp libsnowflakeclient/cacert.pem /usr/local/etc/php/conf.d/

WORKDIR /var/www/html

COPY docker/pdo_snowflake.ini /usr/local/etc/php/conf.d/pdo_snowflake.ini
COPY docker/zip.ini /usr/local/etc/php/conf.d/zip.ini

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
