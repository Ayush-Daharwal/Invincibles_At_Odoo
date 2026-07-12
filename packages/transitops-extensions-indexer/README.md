# transitops-extensions-indexer

Broccoli plugin which indexes transitops extensions installed using npm for the Transitops Console


## Compatibility

* Node.js v14 or above


## Installation

```
yarn add transitops-extensions-indexer
```


## Usage

```js
# ember-cli-build.js
/**
 * After let app = new EmberApp(defaults);
 * initialize the transitops extensions indexer
 */
const extensions = new TransitopsExtensionsIndexer();

/**
 * Add to tree
 */
return app.toTree([extensions]);
```


## Contributing

See the [Contributing](CONTRIBUTING.md) guide for details.


## License

This project is licensed under the [MIT License](LICENSE.md).
