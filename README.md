# API de Fornecedores

Uma API RESTful desenvolvida em **Laravel 12** para gerenciamento de fornecedores com integração à [BrasilAPI](https://brasilapi.com.br/) para consulta de CNPJs no momento do cadastro.

## Funcionalidades

- CRUD de Fornecedores
- Validação de CPF/CNPJ
- Busca de dados de CNPJ via BrasilAPI
- Cache de dados do CNPJ para evitar múltiplas requisições
- Testes automatizados com PestPHP
- Suporte a ambiente de desenvolvimento dockerizado

---

## Subindo o Ambiente de Desenvolvimento

```bash
docker compose up -d --build
```

### Gerar chave da aplicação

```bash
docker exec -it laravel-app php artisan key:generate
```

### Rodar Migrations

```bash
docker exec -it laravel-app php artisan migrate
```

## Testes com PestPHP

Para rodar os testes automatizados:

```bash
docker exec -it laravel-app php artisan test
```

---

## Coleção do Postman

Visando facilitar os testes manuais da API, foi criada uma coleção do Postman.

> `Importe o arquivo teste-dev-php.postman_collection.json no Postman para ter acesso aos endpoints prontos para uso.`

Endpoints incluídos:

- `GET /api/v1/suppliers` – Listagem de fornecedores
- `GET /api/v1/suppliers/{id}` – Visualização individual
- `POST /api/v1/suppliers` – Criação de fornecedor
- `PUT /api/v1/suppliers/{id}` – Atualização de dados
- `DELETE /api/v1/suppliers/{id}` – Exclusão

---

Desenvolvido por **Gustavo Lobo** - [LinkedIn](https://www.linkedin.com/in/gustavo-lobo)
Atualmente desenvolvedor Java (Spring Boot) e React (Next.js).

---

> Inicialmente considerei utilizar o `Inertia` + `Vue` no projeto para o front-end. Porém, revisei e era solicitado a apenas a API. Portanto não dei continuidade.
