# 🔐 IAM Secure API - Arquitetura Segura com Laravel

Projeto demonstrativo de uma API segura com foco em **Identity and Access Management (IAM)**, utilizando Laravel 10 e boas práticas de arquitetura.

Este projeto foi desenvolvido com foco em:
- 🔐 Autenticação segura com JWT
- 👥 Controle de acesso baseado em papéis (RBAC)
- ♻️ Refresh Token
- 🔒 Hash seguro de senhas
- 🧱 Clean Architecture
- 📐 Princípios SOLID
- 🐳 Ambiente Dockerizado
- 📊 Boas práticas de segurança em APIs REST

---

## 🎯 Objetivo do Projeto

Demonstrar na prática:
- Implementação de autenticação segura
- Estruturação de autorização por perfis e permissões
- Separação clara entre camadas da aplicação
- Arquitetura preparada para escalabilidade
- Aplicação de conceitos de segurança em APIs

---

## 🛠 Stack Tecnológica
- PHP 8.2+
- Laravel 10
- MySQL 8
- Redis (cache / sessão)
- Docker
- JWT (tymon/jwt-auth ou Laravel Sanctum)

---

## 🧱 Arquitetura do Projeto

O projeto segue princípios de Clean Architecture e separação de responsabilidades:

src/
├── Domain/
├── Application/
├── Infrastructure/
├── Interfaces/

### 📌 Camadas

- **Domain:** Entidades e regras de negócio puras
- **Application:** Casos de uso e orquestração
- **Infrastructure:** Banco de dados, providers, integrações
- **Interfaces:** Controllers, Requests, Middlewares

---

## 🔐 Funcionalidades de Segurança

- Login com JWT
- Refresh Token
- Middleware de autenticação
- Middleware de autorização por role
- Proteção contra acesso indevido
- Validação robusta de requisições
- Rate limiting
- Hash de senha com bcrypt/argon2

---

## 👥 Modelo de Autorização (RBAC)

O sistema implementa:

- Usuários
- Papéis (Roles)
- Permissões
- Relacionamento many-to-many entre usuários e papéis
- Controle de acesso via middleware

Exemplo:

- ADMIN → acesso total
- MANAGER → acesso parcial
- USER → acesso restrito

---

## 🚀 Como Executar o Projeto

### Clonar repositório

```bash
git clone https://github.com/seu-usuario/iam-secure-api-demo.git
cd iam-secure-api-demo
