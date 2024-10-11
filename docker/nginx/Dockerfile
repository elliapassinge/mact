ARG NGINX_VERSION

FROM nginx:$NGINX_VERSION

RUN apt-get update && apt-get upgrade -y && apt-get install -y \
  apt-transport-https \
  apt-utils \
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
  && apt-get clean

COPY ./sites-enabled/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /srv/mact/public
