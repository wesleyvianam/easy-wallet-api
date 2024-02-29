# Easy Wallet
O Easy Wallet é uma API RESTful PHP desenvolvido sem framework. O intuito deste projeto é simular uma carteira digital.

## Tecnologias
+ PHP 8.2
+ Docker
+ MariaDB

## Dependências
- [Docker & docker compose](https://docs.docker.com/get-docker/)

## Configuração
```bash
docker compose up -d --build
```

## Executar testes
```sh
docker exec easy-app composer test
```
## Endpoints

### Resumo
--- 

#### Usuário
| Tipo   | Caminho        | Descricao                              |
|--------|----------------|----------------------------------------|
| POST   | /api/user      | Cria um novo usuário (Pessoa, Loja)    |
| GET    | /api/user/{id} | Retorna os dados de um usuário         |
| PUT    | /api/user/{id} | Edita usuário selecionado              |
| DELETE | /api/user/{id} | Deleta usuário selecionado             |

#### Transações
| Tipo | Caminho                     | Descricao                             |
|------|-----------------------------|---------------------------------------|
| GET  | /api/user/{id}/balance      | Retorna o saldo atual do usuário      |
| GET  | /api/user/{id}/transactions | Retorna o histórico de transações     |
| POST | /api/user/{id}/transfer     | Realiza transferêcia entre 2 usuários |
| POST | /api/user/{id}/deposit      | Deposita saldo em conta do usuário    |
| POST | /api/user/{id}/withdraw     | Saca o saldo da conta do usuário      | 

### Exemplos
---

#### Usuários

##### [POST]: Criar Usuário
```sh
http://localhost:8080/api/user
```      

Body
```json
{
  "name": "Wesley Viana Martins",
  "email": "wesley@gmail.com",
  "password": "87654321",
  "type": "F",
  "document": "111.222.333-45",
  "phone": "(31) 9 9911-9090"
}

```
Response [200]
```json
{ 
  "id": 1,
  "name": "Wesley Viana Martins",
  "email": "wesley@gmail.com",
  "password": "87654321",
  "type": "F",
  "document": "111.222.333-45",
  "phone": "(31) 9 9911-9090",
  "saldo": "0,00"
}
```

##### [GET]: Dados de um Usuário
```sh
http://localhost:8080/api/user/{id}
```
Response [200]
```json
{
  "id": 1,
  "name": "Wesley Viana Martins",
  "email": "wesley@gmail.com",
  "password": "87654321",
  "document": "111.222.333-45",
  "phone": "(31) 9 9911-9090",
  "saldo": "0,00"
}
```

##### [PUT]: Editar Usuário
```sh
http://localhost:8080/api/user/{id}
```    

Body
```json
{
  "name": "Wesley Viana Martins",
  "email": "wesley@gmail.com",
  "password": "87654321",
  "document": "111.222.333-45",
  "phone": "(31) 9 9911-9090"
}
```
Response [200]
```json
{
  "id": 1,
  "name": "Wesley Viana Martins",
  "email": "wesley@gmail.com",
  "password": "87654321",
  "document": "111.222.333-45",
  "phone": "(31) 9 9911-9090",
  "saldo": "0,00"
}
```

##### [DELETE]: /api/user/{id} - Deleta Usuário
```sh
http://localhost:8080/api/user/{id}
```    
Response [200]
```json
{
  "message": "Usuário deletado com sucesso"
}
```

#### Transações
---
##### [GET]: Saldo do usuário
```sh
http://localhost:8080/api/user/{id}/balance
```    

Response [200]
```json
{
  "saldo": "520,00"
}
```

##### [GET]: Histórico de transações do usuário
```sh
http://localhost:8080/api/user/{id}/transactions
```    
Response [200]
```json
[
  {
     "transactionId": 1,
    "userId": 1,
    "userName": "Wesley Viana Martins",
    "type": "DEPOSIT",
    "subtype": "INCOME",
    "status": "SUCCESS",
    "value": "1.000,00",
    "createdAt": "2024-02-28 07:29:48"
  },
  {
    "transactionId": 5,
    "userId": 1,
    "userName": "Wesley Viana Martins",
    "type": "WITHDRAW",
    "subtype": "EXPENSE",
    "status": "SUCCESS",
    "value": "200,00",
    "createdAt": "2024-02-28 07:29:48"
  }
]
```


##### [POST]: Transferir de um usuário para outro
```sh
http://localhost:8080/api/user/{id}/transfer
```

Body
```json
{
  "user_to": 2,
  "value": "100,00"
}
```

Response [200]
```json
{
  "message": "Transferência autorizada com sucesso"
}
```

##### [POST]: Adicionar saldo na conta de um usuário
```sh
http://localhost:8080/api/user/{id}/deposit
```

Body
```json
{
  "value": "1.000,00"
}
```

Response [200]
```json
{
  "message": "Deposito realizado com sucesso"
}
```

##### [POST]: Sacar saldo em conta do usuário
```sh
http://localhost:8080/api/user/{id}/withdraw
```

Body
```json
{
  "value": "150,80"
}
```

Response [200]
```json
{
  "message": "Saque realizado com sucesso"
}
```