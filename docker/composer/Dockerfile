FROM composer:latest

RUN docker-php-ext-install pdo_mysql \
    && docker-php-ext-install bcmath \
    && apk add composer

RUN mkdir ~/.ssh && chmod 0700 ~/.ssh && ssh-keyscan github.com >> ~/.ssh/known_hosts
