# Transitops

Transitops is a comprehensive logistics and delivery management platform designed for scale, flexibility, and speed. Built from the ground up to handle complex routing, real-time tracking, and orchestration, Transitops offers a complete suite of tools to manage fleets, orders, and field operations.

## Features

- **Core API**: Powerful backend to manage entities, configurations, and users.
- **Console Application**: A feature-rich Ember.js frontend to monitor your operations.
- **Engine System**: Modular plugins (e.g. `fleetops-engine`, `ai-engine`, `valhalla-engine`, `ledger-engine`) to extend the platform's capabilities.
- **Real-Time Tracking**: Integration with WebSockets for real-time driver tracking and status updates.
- **AI Orchestration**: Built-in AI tools for operational queries and predictive routing.
- **Customizable**: Built to be adapted for different supply chain and last-mile delivery needs.

## Architecture

The project is structured as a monorepo for seamless development:

- `api/` - The backend API engine (PHP/Laravel).
- `console/` - The frontend application (Ember.js).
- `packages/` - Modular frontend components, SDKs, and addons (e.g., UI libraries, specialized engines).
- `docker/` - Containerization configurations for easy deployments.

## Getting Started

### Prerequisites
- Docker and Docker Compose
- Node.js & pnpm
- PHP 8.x & Composer

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Ayush-Daharwal/Invincibles_At_Odoo.git transitops
   cd transitops
   ```

2. **Start the Database & Services:**
   ```bash
   docker-compose up -d
   ```

3. **Install Backend Dependencies:**
   ```bash
   cd api
   composer install
   ```

4. **Install Frontend Dependencies:**
   ```bash
   cd ../console
   pnpm install
   ```

5. **Start the Frontend Console:**
   ```bash
   pnpm start
   ```

The Transitops console will be available at `http://localhost:4200`.

## Contributing

We welcome contributions! Please follow our contribution guidelines. Make sure you read our `CODE_OF_CONDUCT.md`.

## License

This project is licensed under the MIT License - see the `LICENSE.md` file for details.
