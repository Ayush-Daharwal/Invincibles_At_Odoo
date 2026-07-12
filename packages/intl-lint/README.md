#  @transitops/intl-lint

### Description

`@transitops/intl-lint` is a Node.js script designed for Ember projects, aimed at validating internationalization (i18n) keys. The script checks that all i18n keys used in JavaScript and Handlebars files of an Ember project are defined in the specified YAML translation file. This validation helps ensure that there are no missing translations in the application, thereby preventing runtime errors and improving the overall quality of internationalization efforts.

### Features

 - Recursively processes JavaScript (.js) and Handlebars (.hbs) files in the specified Ember project directory.
 - Extracts translation keys using tailored regular expressions.
 - Checks if each extracted key exists in the specified YAML translation file.
 - Logs missing translation keys and optionally throws an error.
 - Silent mode to suppress error throwing and complete the script execution even if missing keys are found.

### Installation

To install `@transitops/intl-lint`, run the following command:

```bash
npm install @transitops/intl-lint
```

Or, if you are using pnpm, you can install it using:

```bash
pnpm add @transitops/intl-lint
```

### Usage

Once installed, `@transitops/intl-lint` can be run directly from the command line or used as a Node.js module.

#### Command Line Interface

Run the script in your project's root directory:

```bash
transitops-intl-lint --path "./path-to-ember-project" --translation-path "./path-to-translation.yaml"
```
Optional flags:
- `--silent` or `-s`: Runs the script in silent mode. The script will not throw an error if missing translation keys are found.
- `--path` or `-p`: Specifies the path to the Ember project. Default is ./app.
- `--translation-path`: Specifies the path to the YAML translation file. Default is ./translations/en-us.yaml.

#### As a Node.js Module

You can also require `@transitops/intl-lint` in your Node.js script and use it programmatically:

```javascript
const lint = require('@transitops/intl-lint');

lint({
	silent: true, // or false
	path: './path-to-ember-project',
	translationPath: './path-to-translation.yaml',
});
```

### Authors

- Transitops Pte Ltd hello@transitops.io
- Ronald A. Richardson ron@transitops.io

### Contact

For issues or questions regarding `@transitops/intl-lint`, feel free to contact the authors or raise an issue on the project repository.

### License

`@transitops/intl-lint` is open-source and distributed under the MIT license. See the LICENSE file in the repository for full license text.