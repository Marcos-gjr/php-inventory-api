# php-inventory-api — Gestão de Estoque em PHP Puro

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" />
  <img src="https://img.shields.io/badge/Docker-Conteinerizado-2496ED?style=for-the-badge&logo=docker&logoColor=white" />
  <img src="https://img.shields.io/badge/Licença-MIT-green?style=for-the-badge" />
</p>

<p align="center">
  <strong>API RESTful para controle de estoque, desenvolvida em PHP 8 puro (sem framework) com arquitetura em camadas, PDO parametrizado e ambiente 100% conteinerizado via Docker Compose.</strong>
</p>

---

## 📌 Visão Geral

O **php-inventory-api** é uma aplicação backend para gerenciamento de produtos em estoque. Construído sem frameworks, o projeto demonstra o funcionamento de baixo nível de uma API REST: roteamento dinâmico via expressões regulares, autoloading PSR-4 via Composer, validação de regras de negócio e persistência relacional imune a SQL Injection via prepared statements nativos do PDO.

A API é conteinerizada com Docker (PHP-FPM + Nginx + MySQL), pronta para rodar localmente com um único comando.

---

## 🛠️ Stack Tecnológica

| Camada | Tecnologia | Função |
|---|---|---|
| **Linguagem** | PHP 8.2 (FPM) | Execução backend sem frameworks |
| **Servidor Web** | Nginx (Alpine) | Proxy reverso e roteamento FastCGI |
| **Banco de Dados** | MySQL 8.0 | Persistência relacional (Engine InnoDB) |
| **Acesso a Dados** | PDO (PHP Data Objects) | Comunicação segura via Prepared Statements nativos |
| **Autoloading** | Composer (PSR-4) | Mapeamento automático de namespaces (`App\`) |
| **Containerização** | Docker & Docker Compose | Ambiente isolado com 3 containers integrados |

---

## 📐 Arquitetura do Sistema

Separação rígida de responsabilidades em 4 camadas, garantindo desacoplamento e testabilidade:

```text
[ Cliente HTTP (cURL/Postman) ]
               │
               ▼
      [ Nginx / public/index.php ] ──► (Front Controller + Router Regex)
               │
               ▼
     [ Controllers Layer ]        ──► (Extrai payload e delega execução)
               │
               ▼
      [ Services Layer ]          ──► (Aplica regras de negócio e validações)
               │
               ▼
    [ Repositories Layer ]        ──► (Persistência PDO e Prepared Statements)
               │
               ▼
     [ MySQL Database ]
```

### Detalhamento das Camadas

| Camada | Namespace | Responsabilidade |
|---|---|---|
| Controller | `App\Controllers` | Recebe a requisição, extrai parâmetros e delega ao Service. Retorna `Response::json()`. |
| Service | `App\Services` | Regra de negócio (validação de SKU, sanitização, orquestração). |
| Repository | `App\Repositories` | Comandos SQL puros via PDO parametrizado (SELECT/INSERT). |
| Model | `App\Models` | DTO tipado representando as entidades do banco. |

---

## 📁 Estrutura de Pastas

```text
php-inventory-api/
├── .env.example            # Variáveis de ambiente de modelo
├── .gitignore
├── Dockerfile               # Imagem PHP-FPM 8.2 (Alpine)
├── docker-compose.yml       # Orquestração (app, webserver, db)
├── nginx.conf                # Configuração do Nginx/FastCGI
├── composer.json             # Dependências e mapeamento PSR-4
├── LICENSE                   # Licença MIT
├── README.md
├── public/
│   └── index.php             # Ponto de entrada (Front Controller)
├── sql/
│   └── init.sql               # Script de inicialização do MySQL
└── src/
    ├── Controllers/           # ProdutoController
    ├── Core/                  # Router, Request, Response, Database
    ├── Exceptions/            # ValidationException
    ├── Models/                # Produto
    ├── Repositories/          # ProdutoRepository
    └── Services/              # EstoqueService
```

---

## 🚀 Como Executar

### Pré-requisitos
Docker e Docker Compose instalados na máquina.

### 1. Clonar o repositório e configurar o ambiente
```bash
git clone https://github.com/Marcos-gjr/php-inventory-api.git
cd php-inventory-api
cp .env.example .env
```

### 2. Subir os containers
```bash
docker compose up -d --build
```
A API estará acessível em `http://localhost:8080`.

### 3. Acessar o banco (opcional — via DBeaver ou outro client SQL)
Host: localhost
Porta: 3306
Banco: inventory_db

---

## 🧪 Teste Rápido (Postman/Insomnia)

Para uma validação rápida sem consultar documentação completa:

| Método | URL | Body |
|---|---|---|
| `GET` | `http://localhost:8080/produtos` | — |
| `POST` | `http://localhost:8080/produtos` | `{ "nome": "Produto Teste", "sku": "SKU-001", "quantidade": 10 }` |

---

## 👨‍💻 Desenvolvedor

Desenvolvido por [Marcos Paulo Gonçalves Junior](https://github.com/Marcos-gjr).

## 📜 Licença

Este projeto é software livre distribuído sob os termos da Licença MIT.
