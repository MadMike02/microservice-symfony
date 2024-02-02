# MICROSERVICE USING SYMFONY
This project is for the learning of creating the microservice for find suitable promotions applicable on a certain product using symfony framework.

## COMMANDS

### statrting dev server
symfony server start

### entity 
php bin/console make:entity EntityName
- create entities
- for relations use type as `relation`
- Available relations - ManyToOne, OneToOne, ManyToMany, OneToMany.

### docker setup with mysql
php bin/console make:docker:database
- created docker compose file for database

docker-compose up -d
- build docker image from docker compose file

symfony console doctrine:migrations:migrate
- run migration for docker mysql setup

symfony console make:migration
- create migration files for docker setup

### local setup with mysql

php bin/console make:migration
- for local setup and take configurations from .env file

php bin/console doctrine:migrations:migrate
- for local setup and take configurations from .env file