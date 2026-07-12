# Testing Process: Unit and Integration Testing

Our testing strategy is divided into two primary phases: **Unit Testing** and **Integration Testing**. The goal is to ensure individual functions work correctly in isolation and that different components of the application work together seamlessly.

## 1. Unit Testing

Unit testing involves testing individual functions, methods, or components in isolation to verify they produce the expected output for a given input.

### How We Did It
- **Framework:** We used **Jest** as our primary testing framework due to its rich feature set, assertion library, and built-in mocking capabilities.
- **Scope:** We focused on writing unit tests for our core business logic, utility functions, and individual controller methods.
- **Mocking:** We heavily utilized Jest's mocking features (`jest.mock`) to isolate the code under test. For example, when testing a controller, we mocked the database service or external APIs so that the test only evaluated the controller's logic (e.g., HTTP response codes, error handling) without making actual database queries.
- **Execution:** Tests are collocated with their respective files (e.g., `vehicle.controller.test.ts` next to `vehicle.controller.ts`) and run via the `npm test` script.

**Example Process:**
1. Define the inputs for the function.
2. Mock dependencies (e.g., database models or external services).
3. Call the function.
4. Assert that the function returned the correct output and that the mocked dependencies were called with the correct arguments.

## 2. Integration Testing

Integration testing involves testing how different parts of the system work together. This ensures that the database, external APIs, and our application logic communicate properly.

### How We Did It
- **Tools:** We used **Jest** alongside **Supertest** to make HTTP requests to our application endpoints.
- **Scope:** We tested the entire request-response cycle. This includes hitting the API endpoints, processing the request through middleware (like authentication or validation), executing the controller logic, querying a test database, and returning the response.
- **Test Database:** We utilized a dedicated test database (or an in-memory database like SQLite/MongoDB Memory Server) to ensure that tests do not interfere with development or production data. Before each test suite, the database is seeded with necessary dummy data, and after the tests, it is cleaned up.
- **Execution:** We structured these tests under a separate `tests/integration/` directory to distinguish them from unit tests.

**Example Process:**
1. Set up the test database and seed initial data.
2. Use Supertest to send an HTTP request (e.g., `GET /api/vehicles`) to the Express app.
3. Assert the HTTP status code (e.g., `200 OK`).
4. Assert the structure and content of the response body against expected database records.
5. Tear down or rollback the database state after the test completes.

## Summary
- **Unit Tests** run quickly and verify the internal logic of individual pieces.
- **Integration Tests** are slightly slower but give us confidence that our API endpoints and database connections function properly together.
- This dual approach ensures high code coverage and reliability before any code is deployed to production.
