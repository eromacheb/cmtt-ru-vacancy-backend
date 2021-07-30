FROM mysql:5.7

RUN echo "Europe/Moscow" > /etc/timezone && ln -snf /usr/share/zoneinfo/Europe/Moscow /etc/localtime \
    && apt-get update -y \
    && apt-get upgrade -y

COPY init.sql /docker-entrypoint-initdb.d/