FROM php:7.2-cli

# New sources
RUN apt-get update
RUN apt-get install -y curl apt-transport-https wget nano
RUN apt-get install -my wget gnupg
RUN curl https://packages.microsoft.com/keys/microsoft.asc | iconv -f windows-1251 | apt-key add -
RUN curl https://packages.microsoft.com/config/debian/8/prod.list > /etc/apt/sources.list.d/mssql-release.list
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# install SQL Server drivers
RUN apt-get update && ACCEPT_EULA=Y apt-get install -y unixodbc-dev msodbcsql && ACCEPT_EULA=Y apt-get install -y mssql-tools

# Install php extensions
RUN apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev
#RUN docker-php-ext-install -j$(nproc) iconv mbstring pdo_mysql soap
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/

# Install msodbcsql
RUN ACCEPT_EULA=Y apt-get install -y msodbcsql

# Install sqlsrv
RUN pecl install sqlsrv pdo_sqlsrv
RUN docker-php-ext-enable sqlsrv pdo_sqlsrv
RUN docker-php-ext-install pdo mbstring
RUN apt-get update -y && apt-get install -y openssl zip unzip

RUN pecl install redis-4.0.1 xdebug-2.6.0
RUN docker-php-ext-enable redis xdebug

WORKDIR /app
COPY . /app

RUN composer install

CMD cd /app

CMD composer update

CMD php artisan swagger-lume:generate
CMD php artisan cache:clear
CMD php artisan route:cache
CMD php artisan config:cache
CMD php artisan optimize

CMD php -S 0.0.0.0:8080 -t public

EXPOSE 8080