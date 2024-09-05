#!/bin/bash

  sudo apt update
  sudo add-apt-repository ppa:ondrej/php
  sudo apt update
  sudo apt install php8.3

  sudo cp .env.example .env

  sudo docker run --rm -u root -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php83-composer:latest composer install --ignore-platform-reqs

  ./vendor/bin/sail up -d

  sleep 40

  CONTAINERS=$(docker ps --filter "name=laravel.test" --format "{{.Names}}")

  if [ -z "$CONTAINERS" ]; then
      echo "Nenhum container correspondente foi encontrado. Verifique o nome do container."
      exit 1
  fi

  if [[ $(echo "$CONTAINERS" | wc -l) -gt 1 ]]; then
      echo "Mais de um container encontrado. Usando o primeiro da lista."
      CONTAINER_NAME=$(echo "$CONTAINERS" | head -n 1)
  else
      CONTAINER_NAME=$CONTAINERS
  fi

  docker exec -u root $CONTAINER_NAME bash -c "chown sail:sail -R storage/*"
  docker exec -u root $CONTAINER_NAME bash -c "chown sail:sail -R app/*"
  docker exec -u root $CONTAINER_NAME bash -c "chown sail:sail -R database/*"
  docker exec -u root $CONTAINER_NAME bash -c "chown sail:sail -R public/*"

  echo "Permissões ajustadas com sucesso no container: $CONTAINER_NAME!"