# Dockerization

### Requirements
You needs to have `docker` and `docker-composer` installed on your computer.

For install docker : https://docs.docker.com/engine/install/ubuntu/ \
For install docker-compose : https://docs.docker.com/compose/install/

### Deploy docker stack
#### 1. You must be create `network` 
`docker network create proxy_network_mact && docker network create shared_mact` permish to all services to communicate together inside and behind of docker. \
For example, if you have database in your computer and other services, you can disabled services and use them with this parameters :
```yaml
services:
    ...
    mact-php:
        ...
        extra_hosts:
            - "host.docker.internal:host-gateway"
        ...
    ...
```

#### 2. You need to build services
Many services needs to be builds (Rabbit, Php, Nginx) with `docker-compose build` \
You need to copy vars in `.env.docker.dist` into `.env` before.

#### 3. Start services
`docker-compose up -d` \
`-d` is an option for launch services as deamon


#### 4. Connect to services 

| Services    | Url                        | Authentication  |
|-------------|----------------------------|-----------------|
| Traefik     | traefiK.mact.localhost     |                 |
| Rabbitmq    | rabbitmq.mact.localhost    | guest / guest   |
| mailcatcher | mail.mact.localhost        |                 |
| database    | localhost (for visualizer) | mact / pass     |
| redis       | localhost (for visualizer) |                 |
