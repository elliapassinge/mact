ARG NGINX_VERSION

FROM nginx:$NGINX_VERSION

RUN apt-get update && apt-get upgrade -y

RUN apt-get install -y \
 apt-utils \
 apt-transport-https \
 build-essential \
 ca-certificates \
 curl \
 dnsutils \
 git \
 gnupg \
 iputils-ping \
 libcurl4-openssl-dev \
 net-tools \
 wget \
 zip \

COPY ./sites-enabled/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /srv/mact/public
