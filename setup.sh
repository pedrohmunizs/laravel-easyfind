#!/bin/bash

if grep -q Microsoft /proc/version; then
  echo "Script está sendo executado no WSL"
else
  echo "Script está sendo executado no PowerShell. Abrindo WSL..."
  wsl.exe bash -c "./path/to/your/script.sh"
  exit 0
fi

# Inicia o Docker Desktop se ele não estiver em execução
if ! pgrep -x "Docker Desktop" > /dev/null; then
  echo "Iniciando o Docker Desktop..."
  powershell.exe -Command "& {Start-Process -FilePath 'C:/Program Files/Docker/Docker/Docker Desktop.exe' -Verb RunAs}"
  
  # Espera o Docker Desktop iniciar
  echo "Aguardando o Docker iniciar..."
  while ! docker system info > /dev/null 2>&1; do
    sleep 1
  done
  echo "Docker iniciado com sucesso."
else
  echo "Docker Desktop já está em execução."
fi

# Verifica se o Docker está instalado
if ! [ -x "$(command -v docker)" ]; then
  echo 'Erro: Docker não está instalado.' >&2
  exit 1
fi

# Verifica se o Docker Compose está instalado
if ! [ -x "$(command -v docker-compose)" ]; then
  echo 'Erro: Docker Compose não está instalado.' >&2
  exit 1
fi

# Verifica se o Composer está instalado
if ! [ -x "$(command -v composer)" ]; then
  echo 'Erro: Composer não está instalado.' >&2
  exit 1
fi

# Instala as dependências do Composer se a pasta 'vendor' não existir
if [ ! -d "vendor" ]; then
  composer install
fi

# Instala o Laravel Sail se não estiver instalado
if [ ! -f "vendor/bin/sail" ]; then
  composer require laravel/sail --dev
  php artisan sail:install
fi

# Copia o arquivo .env de exemplo se o .env não existir
if [ ! -f ".env" ]; then
  cp .env.example .env
fi

# Sobe os containers do Sail em modo detached
./vendor/bin/sail up -d
