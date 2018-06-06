# php7/Dockerfile
FROM php:7.2-fpm

ENV APP_ENV=prod
ENV APP_SECRET=c948f2f28993826a697f61cacf4fcaad
ENV DATABASE_URL="mysql://root:@127.0.0.1:3306/pg_annuel"
#ENV NVM_DIR /usr/local/nvm # or ~/.nvm , depending
#ENV NODE_VERSION 8.11.2

# Install nvm with node and npm
#RUN curl https://raw.githubusercontent.com/creationix/nvm/v0.33.11/install.sh | bash \
#    && . $NVM_DIR/nvm.sh \
#    && nvm install $NODE_VERSION \
#    && nvm alias default $NODE_VERSION \
#    && nvm use default

#ENV NODE_PATH $NVM_DIR/v$NODE_VERSION/lib/node_modules
#ENV PATH      $NVM_DIR/v$NODE_VERSION/bin:$PATH

#RUN apt-get update && apt-get upgrade -y

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/app/

RUN chmod -R 777 ./

ADD entrypoint.sh /

CMD ["/bin/sh", "/entrypoint.sh"]