# php-inventory-api — Gestão de Estoque em PHP Puro

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white" />
  <img src="https://img.shields.io/badge/Docker-Conteinerizado-2496ED?style=for-the-badge&logo=docker&logoColor=white" />
  <img src="https://img.shields.io/badge/PHPUnit-10.x-3C99D4?style=for-the-badge&logo=phpunit&logoColor=white" />
  <img src="https://img.shields.io/badge/Licença-MIT-green?style=for-the-badge" />
</p>

<p align="center">
  <strong>API RESTful para controle de estoque e movimentações, desenvolvida em PHP 8 puro com arquitetura em camadas, PDO parametrizado, Docker Compose e testes unitários.</strong>
</p>

---

## 📌 Visão Geral

O **php-inventory-api** é uma aplicação backend projetada para gerenciar produtos e suas respectivas movimentações de estoque (entradas e saídas). Construído sem frameworks, o projeto demonstra o funcionamento de baixo nível de uma API REST, cobrindo roteamento dinâmico via expressões regulares, autoloading PSR-4 via Composer, validações rigorosas de negócio e persistência relacional imune a SQL Injection.

A API é conteinerizada com Docker e Nginx, pronta para execução em ambiente local ou produção com apenas um comando.

---

## ⚙️ Funcionalidades Principais

- **Cadastro e Listagem de Produtos:** Inclusão de produtos com código SKU único e saldo inicial.
- **Registro de Movimentações:** Lançamento de movimentações de `entrada` ou `saida` com validação de saldo disponível e motivo obrigatório.
- **Cálculo de Saldo Consolidado:** Endpoint específico para auditoria de saldo, somando histórico de entradas e subtraindo saídas.
- **Validação Robustecida:** Interceptação de dados inválidos (SKU duplicado, saldo insuficiente, quantidade negativa) com retorno de erros no padrão JSON.
- **Testes de Unidade:** Cobertura automatizada para as regras de negócio de cálculo de saldo e integridade do estoque.

---

## 🛠️ Stack Tecnológica

| Camada | Tecnologia | Função |
|---|---|---|
| **Linguagem** | PHP 8.2 (FPM) | Execução backend sem frameworks |
| **Servidor Web** | Nginx (Alpine) | Proxy reverso e tratamento de requisições HTTP |
| **Banco de Dados** | MySQL 8.0 | Persistência relacional com suporte a Engine InnoDB |
| **Acesso a Dados** | PDO (PHP Data Objects) | Comunicação segura via Prepared Statements nativos |
| **Autoloading** | Composer (PSR-4) | Mapeamento automático de namespaces (`App\`) |
| **Testes** | PHPUnit 10 | Testes de unidade para a camada de serviço |
| **Containerização** | Docker & Docker Compose | Ambiente isolado com 3 containers integrados |

---

## 📐 Arquitetura do Sistema

A aplicação segue a separação rígida de responsabilidades em 4 camadas centrais, garantindo desacoplamento, legibilidade e alta testabilidade:

```text
[ Cliente HTTP (cURL/Postman) ]
               │
               ▼
      [ Nginx / public/index.php ] ──► (Front Controller + Router Regex)
               │
               ▼
     [ Controllers Layer ]        ──► (Extrai Payload e delega execução)
               │
               ▼
      [ Services Layer ]          ──► (Aplica Regras de Negócio e Validações)
               │
               ▼
    [ Repositories Layer ]        ──► (Persistência PDO e Prepared Statements)
               │
               ▼
     [ MySQL Database ]
