# Forme Crosswise

Adds End To End helper routes to a [Forme Framework](https://github.com/formewp/forme-framework) project.

## Overview

Crosswise provides a set of protected endpoints that are only available in testing environments. These endpoints help facilitate common testing operations like user creation, database migrations, and running arbitrary PHP code from your front end during end to end tests.

Crosswise is inspired by and derived from [laracasts/cypress](https://github.com/laracasts/cypress).

## Installation

```bash
composer require forme/crosswise --dev
```

## Available Endpoints

All endpoints are prefixed with `/__e2e__` and are only accessible when `WP_ENV=testing`.

### Create (`POST /__e2e__/create`)
Creates a new model instance with the given attributes.
```json
{
    "model": "App\\Models\\Post",
    "attributes": {
        "title": "Test Post",
        "content": "Test Content"
    }
}
```

### Login (`POST /__e2e__/login`)
Creates and/or logs in a user. Returns the user object.
```json
{
    "id": 1,              // optional - specific user ID
    "role": "subscriber"  // optional - defaults to "subscriber"
}
```

### Current User (`GET /__e2e__/current-user`)
Returns the currently logged-in user.

### Migrate (`GET /__e2e__/migrate`)
Runs all pending database migrations.

### Rollback (`GET /__e2e__/rollback`)
Rolls back all database migrations.

### Run PHP (`POST /__e2e__/run-php`)
Executes arbitrary PHP code and returns the result.
```json
{
    "command": "App\\Models\\Post::count()"
}
```

## Security

All endpoints are protected by Forme's `TestOnlyMiddleware` which ensures they can only be accessed when `WP_ENV=testing`. The Rollback endpoint has an additional redundant check to make double sure of this.

It goes without saying that you should _never_ install or enable Crosswise in production environments.

## Usage Examples

```js
// basic usage
await axios.post('/__e2e__/login', {
    role: 'administrator'
});

await axios.post('/__e2e__/create', {
    model: 'App\\Models\\Post',
    attributes: {
        title: 'Test Post',
        status: 'publish'
    }
});
```

```ts
// Cypress command example
/**
 * create a model instance
 *
 * @example cy.create('App\\Models\\Post', { title: 'Test Post', status: 'publish'});
 */
Cypress.Commands.add('create', (model: string, attributes: { [key: string]: any } = {}) => {
    let requestBody = { model, attributes };
    return cy.request({
        method: 'POST',
        url: '/__e2e__/create',
        body: { ...requestBody },
        log: false,
    }).
        then(({ body }) => {
            Cypress.log({
                name: 'create',
                message: model + ' created successfully',
                consoleProps: () => ({ result: body }),
            });
        }).
        its('body', { log: false });
});

// then use it in your tests
cy.create('App\\Models\\Post', { title: 'Test Post', status: 'publish' });
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
```
