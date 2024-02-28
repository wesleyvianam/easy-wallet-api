# Easy Wallet API

## Sobre o Projeto
O Easy Wallet API é um projeto desenvolvido utilizando PHP 8.2, Docker e MariaDB. Este projeto simula uma carteira digital.

## Instalação do Projeto

  Para instalação do projeto é necessário ter o **docker** e **docker compose** instalado. 
  - [Docker](http://localhost:8000) 
  - [Docker Compose](http://localhost:8000) 

### Passos de Instalação
Para instalar todas as dependências do projeto.
```bash
  composer install
```
Rode o comando para subir os containers, e a aplicação estará disponível na url http://localhost:8989/.
```bash
  docker compose up -d
```

O banco de dados será criado automaticamente juntos com 4 usuários, (2 pessoas, 2 logistas), algumas transações entre eles.

---
## Rotas Disponíveis
#### Usuário:
| Tipo   | Caminho        | Descricao                              |
|--------|----------------|----------------------------------------|
| POST   | /api/user      | Cria um novo usuário (Pessoa, Logista) |
| GET    | /api/user/{id} | Lista os dados do usuário selecionado  |
| PUT    | /api/user/{id} | Edita usuário selecionado              |
| DELETE | /api/user/{id} | Deleta usuário selecionado             |
#### Transações:
| Tipo | Caminho                     | Descricao                             |
|------|-----------------------------|---------------------------------------|
| GET  | /api/user/{id}/balance      | Retorna o saldo atual do usuário      |
| GET  | /api/user/{id}/transactions | Retorna o histórico de transações     |
| POST | /api/user/{id}/transfer     | Realiza transferêcia entre 2 usuários |
| POST | /api/user/{id}/deposit      | Deposita saldo em conta do usuário    |
| POST | /api/user/{id}/withdraw     | Saca o saldo da conta do usuário      | 
 
## Guia de utilização dos endpoints

### Rotina de usuários:
---
 
#### [POST] - Criar Usuário
```sh
/api/user
```      
```json
{
  "name": "Wesley Viana Martins",
  "email": "wesley@gmail.com",
  "password": "87654321",
  "type": "F",
  "cpf": "111.222.333-45",
  "phone": "(31) 9 9911-9090",
}
```
Response 200
```json
{ 
  "id": 1,
  "name": "Wesley Viana Martins",
  "email": "wesley@gmail.com",
  "password": "87654321",
  "type": "F",
  "cpf": "111.222.333-45",
  "phone": "(31) 9 9911-9090",
  "saldo": "0,00"
}
```

#### [PUT]: Editar Usuário
```sh
/api/user/{id}
```    
```json
{
  "name": "Wesley Viana Martins",
  "email": "wesley@gmail.com",
  "password": "87654321",
  "cpf": "111.222.333-45",
  "phone": "(31) 9 9911-9090"
}
```
Response 200
```json
{
  "id": 1,
  "name": "Wesley Viana Martins",
  "email": "wesley@gmail.com",
  "password": "87654321",
  "name": "Wesley Viana Martins",
  "cpf": "111.222.333-45",
  "phone": "(31) 9 9911-9090",
  "saldo": "0,00"
}
```
#### [GET]: Busca Dados do Usuário
```sh
/api/user/{id}
```
Response 200
```json
{
  "id": 1,
  "name": "Wesley Viana Martins",
  "email": "wesley@gmail.com",
  "password": "87654321",
  "name": "Wesley Viana Martins",
  "cpf": "111.222.333-45",
  "phone": "(31) 9 9911-9090",
  "saldo": "0,00"
}
```

#### [DELETE]: /api/user/{id} - Deleta Usuário
```sh
/api/user/{id}
```    
Response 200
```json
{
  "message": "Usuário deletado com sucesso",
}
```

### Rotina de Transações:

#### [GET]: /api/user/{id}/transactions
+ Response 200

      { 
        "data": "....",
      }

#### [GET]: /api/user/{id}/balance
+ Response 200

      { 
        "saldo": "0,00"
      }
