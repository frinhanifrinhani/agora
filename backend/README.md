# App Ágora Site
## Build 

**Requisitos** 

Para executar o projeto localmente, é interessante ter o algum Sistema de Gerenciamento de Banco de Dados (SGBD) instalado e configurado na máquina. 

- Adicionar o arquivo .env na raiz do projeto 

**Iniciar os containers definidos no docker-compose.yml**
```sh
docker-compose up -d --build
```

**Listar os containers em execução**
```sh
docker ps
```

## Configuração do arquivo .env no backend

Criar o arquivo .env na raiz do backend e passar as configurações do banco:

**A porta pode variar de acordo com necessidades pessoais, atualmente 5433. Ver no arquivo docker-compose.yml**
```sh
DB_CONNECTION=pgsql
DB_HOST=banco_agora
DB_PORT=5433
DB_DATABASE=agora
DB_USERNAME=agora
DB_PASSWORD=agorasaude
```

**Instalar dependências e rodar as migrações do Banco De Dados**
```sh
docker exec -it agora_fiocruz-php-fpm-1 composer install 
```
```sh
docker exec -it frontend_agora npm install
```
```sh
docker exec -it agora_fiocruz-php-fpm-1 php artisan key:generate

docker exec -it agora_fiocruz-php-fpm-1 php artisan migrate

docker exec -it agora_fiocruz-php-fpm-1 php artisan db:seed
```

**Reiniciar os containers**
```sh
docker compose up -d
```