<p align="center">
    <p align="center">
        <img src="https://github.com/user-attachments/assets/afac09ee-1fbf-423b-b2a6-7f05a06b12b2" width="180" height="180" />
    </p>
    <p align="center">
        Starter Extension for Transitops
    </p>
</p>

---

## Overview

This monorepo contains both the frontend and backend components for a Skeleton/Starter extension for Transitops. The frontend is built using Ember.js and the backend is implemented in PHP.

* PHP 8.2 or above
* Ember.js v5.4 or above
* Ember CLI v5.4 or above
* Node.js v18 or above

## Structure

```
├── addon
├── app
├── assets
├── translations
├── config
├── node_modules
├── server
│ ├── config
│ ├── data
│ ├── migrations
│ ├── resources
│ ├── src
│ ├── tests
│ └── vendor
├── tests
├── testem.js
├── index.js
├── package.json
├── phpstan.neon.dist
├── phpunit.xml.dist
├── pnpm-lock.yaml
├── ember-cli-build.js
├── composer.json
├── CONTRIBUTING.md
├── LICENSE.md
├── README.md
```

## Installation

### Backend

Install the PHP packages using Composer:

```bash
composer require transitops/core-api
composer require transitops/starter-api
```
### Frontend

Install the Ember.js Engine/Addon:

```bash
pnpm install @transitops/starter-engine
```

## Usage

### Backend

🧹 Keep a modern codebase with **PHP CS Fixer**:
```bash
composer lint
```

⚗️ Run static analysis using **PHPStan**:
```bash
composer test:types
```

✅ Run unit tests using **PEST**
```bash
composer test:unit
```

🚀 Run the entire test suite:
```bash
composer test
```

### Frontend

🧹 Keep a modern codebase with **ESLint**:
```bash
pnpm lint
```

✅ Run unit tests using **Ember/QUnit**
```bash
pnpm test
pnpm test:ember
pnpm test:ember-compatibility
```

🚀 Start the Ember Addon/Engine
```bash
pnpm start
```

🔨 Build the Ember Addon/Engine
```bash
pnpm build
```

## Contributing
See the Contributing Guide for details on how to contribute to this project.

## License
This project is licensed under the MIT License.