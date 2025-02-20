# Introdução

myTasks Server - Aplicação para cadastro de tarefas.

# Pré-requisitos

- Docker
- docker-compose

# Sobre o build

Esta API foi criada com a utilização das seguintes ferramentas:

- Laravel 11.x
- Laravel Sail (Docker)
- PostgreSQL

# Adicionando o Laravel Sail

Para configurar um alias para o Sail e executar os comandos mais facilmente, rode o seguinte no terminal dentro do diretório do projeto:

`alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'`

Caso você não queira executar esse passo, execute os comandos do Sail através do comando:

`./vendor/bin/sail up`

# Execução

Para rodar a API garanta que o Docker e o docker-compose estejam instalados e rodando na sua máquina. Após essa verificação rodar os seguintes comandos:

- composer install
- cp .env.example .env
- php artisan key:generate
- sail up

Após o build da imagem, os containers estarão prontos e a aplicação estará disponível no endereço: http://localhost.

# Migrations e seeders

Execute os seguintes comandos:

- sail artisan migrate
- sail db:seed

O comando de seed disponibiliza no banco de dados o seguinte usuário para testes:

- email: admin@tasks.com
- senha: admin

Algumas categorias e tarefas inicias também são criadas através do seed.
