# EasyFind

Este é um projeto de um marketplace usando Sail Laravel. Este guia irá orientá-lo a configurar o ambiente de desenvolvimento na sua máquina local, utilizando um ambiente Ubuntu.

Este é um projeto de um marketplace que dejesa apresentar estabelecimento próximos ao cliente e fazer com que estabelecimentos menores sejam vistos por novos clientes, baseando a busca dos produtos pela sua localização.
Nesse mesmo projeto tem tanto a parte do comerciante quanto a do consumidor.

## Requisitos

* Composer
* Docker

## Rodar projeto

Digite no terminal para poder configurar e rodar o projeto pela primeira vez.
```
./setup.sh
```
Após executar o script e levantar os containers, digite esse comando para executar as migrations do projeto 
```
sail artisan migrate
```
Para finalizar, execute a seeder para inserir dados iniciais em algumas tabelas com o comando 
```
sail artisan db:seed
```
Pronto, agora você pode utilizar o projeto acessando http://localhost:80

Depois que você configurou pela primeira vez, não é necessário executar o script de configuração novamente, você pode utilizar esse comando
```
./run-dev.sh
```
Para derrubar os containers é só executar 
```
ctrl + c
```

## Ajuda

Caso quando acessar o localhost:80 e tiver um erro como Failed to open stream: Permission denied
* Pirmeiro entre no container laravel-easyfind-laravel.test-1
```
docker exec -it laravel-easyfind-laravel.test-1 bash
```
* Dentro do container rode esse comando para que os arquivos da storage pertençam ao usuário sail.
```
chown sail:sail -R storage/*
chown sail:sail -R app/*
chown sail:sail -R database/*
chown sail:sail -R public/*
```
