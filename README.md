<div align="center">

# 🚌 TransitOps

**Enterprise-Grade Fleet & Transit Operations Management Platform**

*Built for scale. Designed for operators. Optimized for real-time.*

[![License: MIT](https://img.shields.io/badge/License-MIT-violet.svg)](LICENSE.md)
[![Backend: Laravel](https://img.shields.io/badge/Backend-Laravel%2011-red.svg)](https://laravel.com)
[![Frontend: Ember.js](https://img.shields.io/badge/Frontend-Ember.js-orange.svg)](https://emberjs.com)
[![Docker](https://img.shields.io/badge/Infra-Docker-blue.svg)](https://www.docker.com)
[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](CONTRIBUTING.md)

</div>

---

## 📌 Overview

**TransitOps** is a full-stack, enterprise-ready transit and fleet operations platform designed to streamline every aspect of modern transport management — from real-time vehicle tracking and dispatch automation to role-scoped analytics and compliance reporting.

Whether you manage a city bus fleet, logistics convoy, or last-mile delivery network, TransitOps gives your team the visibility and control they need — all in one unified platform.

---

## ✨ Key Features

| Feature | Description |
|---|---|
| 🗺️ **Live Dispatch Board** | Real-time order management with drag-and-drop trip assignment |
| 🚗 **Fleet Lifecycle Management** | Full vehicle, driver, and maintenance record management |
| 👥 **Role-Based Access Control** | Scoped dashboards for Fleet Managers, Dispatchers, Safety Officers & Financial Analysts |
| 📍 **Real-Time Tracking** | WebSocket-powered live driver location and trip status updates |
| ⛽ **Fuel & Expense Reporting** | Automated fuel log capture and cost analytics per vehicle/route |
| 🛡️ **Safety & Compliance** | Driver license verification, incident reporting, and audit trails |
| 🤖 **AI Route Optimization** | Intelligent routing engine for optimal trip planning |
| 🌐 **Multi-Org Support** | Manage multiple organizations and companies from a single instance |
| 📱 **Responsive Console** | Beautiful glassmorphism UI optimized for desktop and tablet |

---

## 🏗️ Architecture

TransitOps is structured as a **monorepo** combining a Laravel API backend with an Ember.js frontend console, supported by modular engine packages.

```
transitops/
├── api/                    # Laravel 11 backend (REST API + WebSocket)
│   ├── app/                # Core application logic
│   ├── database/           # Migrations, seeders (incl. RBAC seeder)
│   └── config/             # Environment and service configuration
│
├── console/                # Ember.js frontend application
│   ├── app/
│   │   ├── components/     # Reusable UI components
│   │   ├── controllers/    # Route-level business logic
│   │   ├── routes/         # Ember routing layer
│   │   ├── services/       # Cross-cutting concerns (auth, session, API)
│   │   └── templates/      # Handlebars UI templates
│   └── public/             # Static assets
│
├── packages/               # Modular engine extensions
│   ├── fleet-ops-engine/   # Core dispatch & fleet operations engine
│   ├── ai-engine/          # AI-assisted routing and predictions
│   ├── ledger-engine/      # Financial reporting and audit engine
│   └── vroom-engine/       # Vehicle routing optimization (VRP solver)
│
├── docker/                 # Docker service configurations
└── docker-compose.yml      # Full-stack container orchestration
```

---

## 👤 Role-Based Access Control (RBAC)

TransitOps ships with four pre-configured organizational roles, each scoped to their operational domain:

| Role | Primary Domain | Key Permissions |
|---|---|---|
| **Fleet Manager** | Vehicle & asset lifecycle | Manage vehicles, drivers, fleets, maintenance, work orders |
| **Dispatcher** | Live trip execution | Create/manage orders, routes, service areas, zones |
| **Safety Officer** | Driver compliance | Driver records, licensing, incident reports, order visibility |
| **Financial Analyst** | Cost & revenue tracking | Fuel logs, expense reports, financial analytics |

### 🔑 Default Test Credentials

| Role | Email | Password |
|---|---|---|
| Fleet Manager | `fleetmanager@transitops.com` | `password` |
| Dispatcher | `dispatcher@transitops.com` | `password` |
| Safety Officer | `safetyofficer@transitops.com` | `password` |
| Financial Analyst | `financialanalyst@transitops.com` | `password` |

> **Note:** Change all default credentials before deploying to production.

---

## 🚀 Getting Started

### Prerequisites

- **Docker** 20.x+ & **Docker Compose** v2+
- **Node.js** 18.x+ & **pnpm** 8.x+
- **PHP** 8.2+ & **Composer** 2.x+

### Quick Start (Docker)

```bash
# 1. Clone the repository
git clone https://github.com/Ayush-Daharwal/Invincibles_At_Odoo.git transitops
cd transitops

# 2. Copy environment config
cp api/.env.example api/.env

# 3. Start all backend services (API, DB, Cache, Queue, WebSocket)
docker-compose up -d

# 4. Run database migrations and seed RBAC roles + test users
docker-compose exec application php artisan migrate --force
docker-compose exec application php database/seeders/standalone_seed_rbac.php

# 5. Install and start the frontend console
cd console
pnpm install
pnpm start
```

The TransitOps console will be available at **`http://localhost:4200`**
The backend API will be available at **`http://localhost:8000`**

---

## 🔧 Development Setup (Local)

```bash
# Backend
cd api
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve

# Frontend (in a new terminal)
cd console
pnpm install
pnpm start
```

---

## 📡 API Overview

The TransitOps REST API is versioned and organized by domain:

| Prefix | Domain |
|---|---|
| `/int/v1/auth/` | Authentication & session management |
| `/int/v1/fleet-ops/` | Fleet, vehicles, drivers, orders |
| `/int/v1/onboard/` | Organization onboarding |

All API endpoints require a valid **Sanctum bearer token** obtained via the login endpoint.

---

## 🛠️ Tech Stack

**Backend**
- PHP 8.2 / Laravel 11
- MySQL 8.0
- Redis (caching & queues)
- Laravel Sanctum (API auth)
- Spatie Permission (RBAC)
- FrankenPHP (production server)

**Frontend**
- Ember.js 5.x
- Tailwind CSS 3.x
- Ember Concurrency
- Ember Intl (i18n)
- WebSockets (real-time)

**Infrastructure**
- Docker & Docker Compose
- Apache / HTTPD reverse proxy
- Redis queue workers

---

## 🤝 Contributing

We welcome contributions from the community! To get started:

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/your-feature`
3. Commit your changes with clear messages
4. Push to your fork and open a Pull Request

Please read our `CODE_OF_CONDUCT.md` before contributing.

---

## 📄 License

This project is licensed under the **MIT License** — see the [`LICENSE.md`](LICENSE.md) file for details.

---

<div align="center">

Built with ❤️ by the **Invincibles** team · TransitOps © 2024

</div>
