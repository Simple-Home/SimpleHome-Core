FROM webdevops/php-apache-dev:7.4

RUN apt-get update

# install nodejs
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash
RUN apt-get update && apt-get install -y nodejs
RUN npm install -g npm@latest

WORKDIR /app
