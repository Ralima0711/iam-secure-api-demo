# 🔐 IAM Secure API
Clean Architecture + JWT + RBAC + Docker

Projeto de autenticação e autorização desenvolvido com foco em **Arquitetura Limpa, Segurança Corporativa e Boas Práticas de Engenharia de Software**.

Este projeto simula a base arquitetural de um sistema **IAM (Identity and Access Management)** corporativo.

---

# 🚀 Stack Tecnológica

- PHP 8.2
- Laravel 10+
- JWT (stateless authentication)
- MySQL 8
- Docker + Docker Compose
- Nginx
- Clean Architecture
- RBAC (Role-Based Access Control)

---

# 🧱 Arquitetura

O projeto segue os princípios da **Clean Architecture**, promovendo separação clara entre domínio, aplicação e infraestrutura.

## 📂 Estrutura de Camadas

app/
├── Domain/               → Entidades e contratos (interfaces)
├── Application/          → Casos de uso (regras de negócio)
├── Infrastructure/       → Implementações concretas (JWT, DB, Cache)
├── Interfaces/           → Camada HTTP (Controllers, Requests, Middleware)


## 🎯 Princípios Aplicados

- SRP (Single Responsibility Principle)
- DIP (Dependency Inversion Principle)
- Separação entre regra de negócio e framework
- Domain não depende de Laravel
- Application depende apenas de abstrações
- Infraestrutura pode ser substituída sem impacto no domínio

---

# 🧠 Decisões Arquiteturais

## Por que Clean Architecture?

- Isola regra de negócio do framework
- Permite troca de infraestrutura (ex: JWT → OAuth2)
- Facilita testes automatizados
- Evita acoplamento excessivo ao Laravel

## Por que JWT?

- Stateless
- Escalável horizontalmente
- Ideal para microsserviços
- Não depende de sessão no servidor

## Por que RBAC?

- Modelo amplamente utilizado em ambientes corporativos
- Permite granularidade por permissão
- Base para futura implementação multi-tenant

---

# 🔐 Segurança Implementada

## 🔑 Autenticação
- JWT Token
- Refresh Token
- Logout com invalidação

## 🛂 Autorização
- RBAC completo
- Middleware customizado:
  - `role`
  - `permission`

## 🛡 Proteções Aplicadas

- Proteção contra User Enumeration
- Controle de tentativas de login (Anti Brute Force por IP)
- Auditoria persistente de eventos:
  - login_success
  - login_failed
  - login_blocked
- Rate limiting
- Validação via FormRequest

---

# 🧠 Fluxo de Login

1. Validação via FormRequest
2. Verificação de bloqueio por IP
3. Busca usuário via repositório
4. Autenticação via AuthService (abstraído)
5. Registro de auditoria
6. Reset de tentativas após sucesso

---

# 📡 Endpoints Principais

## 🔐 Login

```http
POST /api/auth/login
```http

## 👤 Usuário autenticado

GET /api/auth/me


## 🔄 Refresh Token

POST /api/auth/refresh


## 🔒 Acesso restrito a ADMIN

GET /api/admin-only


## 🔑 Acesso por permissão específica

GET /api/users/create-area


---

# 📊 Auditoria

Eventos críticos são persistidos na tabela:


audit_logs


Campos registrados:

- user_id
- event
- ip
- user_agent
- metadata
- created_at

Essa estrutura permite futura integração com SIEM ou monitoramento centralizado.

---

# 🛡 Proteção contra Brute Force

- Máximo de 5 tentativas por IP
- Bloqueio temporário
- Registro de evento `login_blocked`
- Reset automático após login válido

---

# 🏗 Diagrama de Camadas


```text
HTTP (Controllers)
        ↓
Application (UseCases)
        ↓
Domain (Contracts / Entities)
        ↓
Infrastructure (JWT, DB, Cache)
```


---

# 🐳 Ambiente Dockerizado

O projeto é totalmente containerizado.

## Containers

- PHP-FPM
- Nginx
- MySQL 8

## Subir ambiente

```bash
docker compose up -d --build
```

## Rodar migrations

```bash
docker exec -it iam_app php artisan migrate
```

## Acessar aplicação

http://localhost:8000

##🌎 Considerações para Produção

Em ambiente real recomenda-se:
Redis para cache distribuído
HTTPS obrigatório
Rotação de chaves JWT
Logs enviados para SIEM
Monitoramento com Prometheus
CI/CD automatizado
Healthcheck endpoint
Estratégia de backup do banco
Secrets gerenciados via Vault ou similar

##📈 Evoluções Futuras
Swagger / OpenAPI
Testes automatizados
Multi-tenant IAM
Integração com OAuth2
Integração com SSO
Event-driven audit logging
Rate limit avançado por usuário

🎯 Objetivo Arquitetural
Este projeto demonstra:
Aplicação prática de Clean Architecture
Separação clara de responsabilidades
Segurança aplicada em nível corporativo
Infraestrutura containerizada
Base escalável para sistema IAM real

👩‍💻 Autora
Roberta Alves
Full Stack Developer
