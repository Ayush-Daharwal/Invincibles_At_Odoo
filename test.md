# Comprehensive Testing Process: Unit and Integration Testing

This document outlines the detailed end-to-end testing strategy for our monorepo architecture, encompassing both our frontend applications (Ember.js/React) and our backend engine packages (PHP/Node.js). Our objective is to maintain high code reliability and ensure seamless integration across all microservices and user interfaces.

## 1. Architecture Overview
Our project is a monorepo consisting of multiple independent packages, engines, and frontend applications (e.g., `storefront`, `vroom-engine`, `fleetops-engine`). Testing is tailored to the specific technology stack of each package:
- **Frontend / UI Packages:** Primarily tested using Ember CLI testing tools and QUnit/Mocha.
- **Backend / Engine Packages:** Tested using PHPUnit (for PHP-based engines like `vroom-engine`) and Jest (for Node.js-based services).

---

## 2. Unit Testing Strategy

Unit tests are designed to isolate individual functions, components, or classes, verifying that they perform their specific logic correctly without relying on external dependencies like databases or third-party APIs.

### Backend Unit Testing (PHP / Node.js)
- **Frameworks:** PHPUnit (PHP), Jest (Node/TypeScript).
- **Execution:** 
  - PHP: Run via `vendor/bin/phpunit --testsuite Unit`
  - Node: Run via `npm run test:unit`
- **Mocking & Isolation:** 
  - We use Mockery for PHP and Jest's built-in mocking (`jest.mock()`) for Node.js. 
  - Database calls, cache interactions, and external API requests are rigorously mocked.
  - Controllers are tested by directly injecting mock request objects and asserting on the returned response structure.
- **Coverage:** We aim for at least 80% code coverage on core engine components (`vroom-engine`, `fleetops-engine`).

### Frontend Unit Testing (Ember / React)
- **Frameworks:** QUnit (Ember core packages), Jest/React Testing Library.
- **Component Testing:** We render components in isolation. We pass mock data as properties/arguments and assert that the DOM updates as expected.
- **Action Testing:** We simulate user interactions (clicks, keyboard input) and verify that the correct internal actions or closure actions are triggered.
- **Execution:** Run via `ember test` or `npm run test:components`.

---

## 3. Integration Testing Strategy

Integration tests evaluate how multiple units work together. This is where we test the interaction between controllers, services, databases, and the network layer.

### Backend Integration Testing
- **Objective:** Ensure the API endpoints return the correct data formats and status codes when interacting with a real (but isolated) database.
- **Database Setup:** 
  - We use a dedicated, ephemeral test database (e.g., SQLite in-memory or a dedicated test schema).
  - Database transactions are utilized; we begin a transaction before each test and roll it back afterward to maintain a pristine state (`RefreshDatabase` trait in PHP/Laravel).
- **API Testing:** We use testing utilities (like Laravel's HTTP testing methods or Supertest in Node) to make mock HTTP requests to our endpoints.
- **Validation:** We assert:
  1. The HTTP Status Code (e.g., 200, 201, 403, 404).
  2. The JSON payload structure matches our OpenAPI/Swagger specifications.
  3. The database state has been correctly updated (e.g., a new record was inserted).

### Frontend Integration Testing
- **Objective:** Test how components interact with each other and the application state (Routing, Services, Controllers).
- **Ember Application Tests (Acceptance Tests):**
  - We simulate complete user journeys (e.g., logging in, navigating to the dashboard, and creating a new order).
  - **Network Mocking:** We use tools like Mirage JS or MSW (Mock Service Worker) to intercept network requests and return mock JSON responses. This ensures frontend tests do not require the backend to be running.
  - **DOM Assertions:** We use helpers like `click()`, `fillIn()`, and `visit()` to traverse the application and assert the presence of specific elements.

---

## 4. Continuous Integration (CI) Pipeline Workflow

To ensure no broken code is merged into the `main` branch, all tests are automatically executed via our CI/CD pipelines (e.g., GitHub Actions / GitLab CI).

1. **Linting & Static Analysis:** Before tests run, code is checked against ESLint, Prettier, and PHPStan to catch syntax and typing errors.
2. **Parallel Test Execution:** Tests are split across multiple runners. Frontend and Backend test suites run concurrently to speed up the build process.
3. **Database Migrations:** The CI pipeline automatically spins up a Docker container with the necessary database (MySQL/Postgres), runs all migrations, and executes the integration test suites.
4. **Failure Protocol:** If any test fails, the pull request is blocked from being merged until the developer resolves the issue.

## Summary
By rigorously separating our testing layers—employing fast **Unit Tests** for immediate developer feedback and comprehensive **Integration Tests** to guarantee system-wide health—we ensure a robust, reliable, and scalable application architecture across all our monorepo packages.
