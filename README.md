# Easy Wallet API Documentation

### Sobre o Projeto
O Easy Wallet API é um projeto desenvolvido utilizando PHP 8.2, Docker e MariaDB. Este projeto simula uma carteira digital.

### Instalação do Projeto

  Pré-requisitos:
  - Docker - [documentação](http://localhost:8000) 
  - Docker Compose - [documentação](http://localhost:8000) 

### Passos de Instalação

1. INTALATION ....

### Rotas Disponíveis
| Tipo   | Caminho        | Descricao                  |
|--------|----------------|----------------------------|
| POST   | /api/user/{id} | Rota de criação de usuário |
| PUT    | /api/user/{id} | Rota de edição de usuário  |
| GET    | /api/user/{id} | Lista os dados do usuário  |
| DELETE | /api/user/{id} | Rota de criação de usuário |

## Documentação de Utilização dos Endpoints da API
### Rotina de usuário:
#### [POST]: /api/user
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
      }
