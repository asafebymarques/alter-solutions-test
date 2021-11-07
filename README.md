# Alter Solutions Desafio de PHP

O candidato deverá implementar um pequena aplicação CLI, que atenda às especificações dos casos de uso mencionados a seguir, utilizando
somente a linguagem de programação PHP.

#### Setup & installation without docker
1. Fazer uma cópia do arquivo .env.exemplo para .env na raiz do projeto e cpnfigurar .env com seu banco de dados
```sh
$ cp .env.exemplo .env
```

2. Rodar o comando abaixo para instalar as dependências do projeto:
```
$ composer install
```
3. Rodar o comando abaixo para que seja criado a tabela que será utilizada:
```
$ php vendor/bin/phinx  migrate
```

### Usage 

##### Cadastrar um usuário:
```sh
$ php index.php USER:CREATE
```
Após a execução do comando deverá ser preenchido as informações conforme solicitado pela aplicação. No fim terá sido criado o usuário na tabela `users`

##### Cadastrar uma senha para o usuário:
```sh
$ php index.php USER:CREATE-PWD {ID}
```
Após informar a senha e confirmar ela novamente, será setado o campo `password` do usuário cujo ID foi informado no comando

##### Rodar os testes unitários
```sh
$ composer test
```

#### Setup & installation with docker
1. Fazer uma cópia do arquivo .env.exemplo para .env na raiz do projeto e cpnfigurar .env com seu banco de dados
```sh
$ cp .env.exemplo .env
```

2. Rodar o comando abaixo para subir os containers necessários:
```
$ docker-compose up -d
```

3. Rodar o comando abaixo para que seja criado a tabela que será utilizada:
```
$ docker exec asp-app php vendor/bin/phinx  migrate
```

### Usage 

##### Cadastrar um usuário:
```sh
$ docker exec -it asp-app php index.php USER:CREATE
```
Após a execução do comando deverá ser preenchido as informações conforme solicitado pela aplicação. No fim terá sido criado o usuário na tabela `users`

##### Cadastrar uma senha para o usuário:
```sh
$ docker exec -it asp-app php index.php USER:CREATE-PWD {ID}
```
Após informar a senha e confirmar ela novamente, será setado o campo `password` do usuário cujo ID foi informado no comando

##### Rodar os testes unitários
```sh
$ docker exec -it asp-app composer test
```