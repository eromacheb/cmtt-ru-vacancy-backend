FROM nginx:latest

RUN echo "Europe/Moscow" > /etc/timezone && ln -snf /usr/share/zoneinfo/Europe/Moscow /etc/localtime \
    && apt-get update -y \
    && apt-get upgrade -y

COPY config/ /etc/nginx/