#!/bin/bash

  sudo apt update
  sudo add-apt-repository ppa:ondrej/php
  sudo apt update
  sudo apt install php8.3

  sudo cp .env.example .env

  sudo docker run --rm -u root -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php83-composer:latest composer install --ignore-platform-reqs

  ./vendor/bin/sail up -d

  sail artisan migrate