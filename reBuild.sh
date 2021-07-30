#!/bin/sh

docker-compose stop

docker-compose rm -v -f

docker container prune -f
docker image prune -f
docker volume prune -f
docker network prune -f

docker-compose build
docker-compose up -d --force-recreate
docker container prune -f

docker exec -i php /bin/bash -c "composer update"
sleep 10
docker exec -i php /bin/bash -c "vendor/bin/phinx migrate"