# Easy Wallet

### Sobre o Projeto
O Easy Wallet é uma API RESTful PHP desenvolvido sem framework utilizando. O intuito deste projeto é simular uma carteira digital. tecnologias utilizadas:
+ PHP 8.2
+ Docker
+ MariaDB

### Instalação do Projeto

  Para instalação do projeto é necessário ter o **docker** e **docker compose** instalado. 
  - [Docker & docker compose]([http://localhost:8000](https://docs.docker.com/get-docker/)) 

### Passos de Instalação
Para instalar todas as dependências do projeto.
```bash
  composer install
```
Esta comando starta os containers. A aplicação estará disponível na url http://localhost:8080/.
```bash
  docker compose up -d
```

O banco de dados será criado automaticamente juntos com 4 usuários (2 pessoas, 2 lojas) e algumas transações entre eles.

O sistema não possuí autenticação, então para acessar os dados do usuário específico é só utilizar o **id** do usuário que queira vizualizar ou fazer transações.

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

` Rotina de usuários `
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

` Rotina de Transações `
---
#### [GET]: Histórico de transações do usuário
```sh
/api/user/{id}/transactions
```    
Response 200
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

#### [GET]: Saldo do usuário
```sh
/api/user/{id}/balance
```    
Response 200
```json
{
	"saldo": "520,00"
}
```

#### [POST]: Transferir de um usuário para outro
```sh
/user/1/transfer
```
```json
{
	"user_to": 2,
	"value": "100,00"
}
```
Response 200
```json
{
	"message": "Transferência autorizada com sucesso"
}
```

#### [POST]: Depositar saldo em conta do usuário
```sh
/api/user/1/deposit
```
```json
{
	"value": "1.000,00"
}
```
Response 200
```json
{
	"message": "Deposito realizado com sucesso"
}
```

#### [POST]: Sacar saldo em conta do usuário
```sh
/api/user/1/withdraw
```
```json
{
	"value": "150,80"
}
```
Response 200
```json
{
	"message": "Saque realizado com sucesso"
}
```
