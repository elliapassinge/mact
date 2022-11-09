ARG RABBITMQ_VERSION
FROM rabbitmq:$RABBITMQ_VERSION-management

RUN echo "load_definitions = /mnesia.json" >> /etc/rabbitmq/conf.d/import.conf
COPY ./mnesia.json /mnesia.json
