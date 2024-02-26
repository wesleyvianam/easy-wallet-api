# Easy Wallet API Documentation

## Sobre o Projeto

O Easy Wallet API é um projeto desenvolvido utilizando PHP 8.2, Docker e MariaDB. Este projeto simula uma carteira digital.

## Instalação do Projeto

### Pré-requisitos

Certifique-se de ter o Docker e o Docker Compose instalados em sua máquina antes de prosseguir.

### Passos de Instalação

1. INTALATION ....

## Documentação de Utilização dos Endpoints da API

### Recursos Disponíveis

- **Usuários**
    - `POST /api/user`: Criar um novo usuário
    - `GET /api/user/{id}`: Obter informações do usuário
    - `PUT /api/user/{id}`: Atualizar informações de um usuário
    - `DELETE /api/user/{id}`: Excluir um usuário

- **Authenticação**
    - `POST /api/login`: Logar no sistema
    - `DELETE /api/logout`: Deslogar do sistema

- **Transações**
    - `GET /api/user/{id}/history`: Obter todas as transações do usuário
    - `GET /api/user/{id}/balance`: Obter saldo atual
    - `POST /api/user/{id}/deposit`: Depositar valores na conta
    - `POST /api/user/{id}/withdraw`: Sacar valores da conta
    - `POST /api/user/{id}/transfer`: Transferir dinheiro para outro usuário
