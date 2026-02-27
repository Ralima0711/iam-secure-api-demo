# 🔐 IAM Secure API — Clean Architecture + JWT + RBAC
Projeto de autenticação e autorização desenvolvido com foco em **Arquitetura Limpa, Segurança e Boas Práticas Corporativas**.
Este projeto simula a base de um sistema IAM (Identity and Access Management) corporativo.

---

# 🚀 Stack Tecnológica

- PHP 8.2
- Laravel 10+
- JWT Authentication
- MySQL 8
- Docker
- Nginx
- Clean Architecture
- RBAC (Role-Based Access Control)

---

# 🧱 Arquitetura

O projeto segue os princípios da **Clean Architecture**.

app/
├── Domain/ → Entidades e contratos
├── Application/ → Casos de uso
├── Infrastructure/ → Implementações concretas
├── Interfaces/ → Camada HTTP (Controllers, Requests)


## 🎯 Princípios aplicados

- SRP (Single Responsibility Principle)
- DIP (Dependency Inversion Principle)
- Separação clara entre regra de negócio e framework
- Domain não depende de Laravel
- Application depende apenas de abstrações

---

# 🔐 Segurança Implementada

## Autenticação
- JWT Token
- Refresh Token
- Logout com invalidação

## Autorização
- RBAC completo
- Middleware customizado:
  - role
  - permission

## Proteções aplicadas
- Proteção contra User Enumeration
- Controle de tentativas de login (Anti Brute Force)
- Auditoria de eventos:
  - login_success
  - login_failed
  - login_blocked
- Rate limit

---

# 🧠 Fluxo de Login

1. Validação via FormRequest
2. Verificação de bloqueio por IP
3. Busca usuário via repositório
4. Autenticação via AuthService
5. Registro de auditoria
6. Reset de tentativas

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

Rodar migrations:
docker exec -it iam_app php artisan migrate

Acessar:

http://localhost:8000
📡 Endpoints Principais
🔐 Login
POST /api/auth/login
👤 Dados do usuário
GET /api/auth/me
🔄 Refresh
POST /api/auth/refresh
🔒 Admin Only
GET /api/admin-only
🔑 Permissão específica
GET /api/users/create-area

📊 Auditoria
Todos os eventos críticos são persistidos em:
audit_logs

Campos registrados:
user_id
event
ip
user_agent
metadata
timestamp

🛡 Proteção contra Brute Force
Máximo 5 tentativas por IP
Bloqueio temporário
Log de bloqueio registrado

📈 Evoluções Futuras
Swagger / OpenAPI
Testes automatizados
Redis para cache distribuído
Healthcheck endpoint
Multi-tenant IAM
CI/CD pipeline
Integração com OAuth2

🎯 Objetivo Arquitetural
Este projeto demonstra:
Separação clara de responsabilidades
Aplicação prática de Clean Architecture
Segurança aplicada em nível corporativo
Infraestrutura containerizada
Base para sistema IAM escalável
