# Easy Wallet API Documentation

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
 
#### [POST]: /api/user - Criar Usuário
+ Body
      
      {
        "name": "Wesley Viana Martins",
        "email": "wesley@gmail.com",
        "password": "87654321",
        "name": "Wesley Viana Martins",
        "type": "F", // O tipo precisa ser F ou J
        "cpf": "11147565635"
      }

+ Response 200

      { 
        "id": 1,
        "name": "Wesley Viana Martins",
        "email": "wesley@gmail.com",
        "password": "87654321",
        "name": "Wesley Viana Martins",
        "type": "F", // ou J se for logista
        "cpf": "11147565635"
      }

#### [PUT]: /api/user/{id} - Editar Usuário
+ Body

      {
        "name": "Wesley Viana Martins",
        "email": "wesley@gmail.com",
        "password": "87654321",
        "name": "Wesley Viana Martins",
        "cpf": "11147565635"
      }

+ Response 200

      { 
        "id": 1,
        "name": "Wesley Viana Martins",
        "email": "wesley@gmail.com",
        "password": "87654321",
        "name": "Wesley Viana Martins",
        "type": "F", // ou J se for logista
        "cpf": "11147565635"
      }

#### [GET]: /api/user/{id} - Busca Dados do Usuário
+ Response 200

      { 
        "id": 1,
        "name": "Wesley Viana Martins",
        "email": "wesley@gmail.com",
        "password": "87654321",
        "name": "Wesley Viana Martins",
        "type": "F",
        "cpf": "11147565635",
        "saldo": "0,00"
      }

#### [DELETE]: /api/user/{id} - Deleta Usuário
+ Response 200

      { 
        "message": "Usuário deletado com sucesso",
      }

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