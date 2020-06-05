# Unofficial ConvertKit

Unofficial ConvertKit plugin for WordPress.

## Things ToDo

* [ ] Setup phpunit
* [ ] Setup phpcs with wordpress code style
* [ ] Setup webpack
* [ ] Setup eslint with wordpress style
* [ ] Setup github actions (CI) 

## Plugin requirements

- PHP >= 7
- Wordpress >= 5

## Requirements

Those are the requirements for `1.0.0` release 

Admin menu item: Settings > Unofficial Convertkit

### Must:
- Tab op settings page: ConvertKit (voor connectie leggen met ConvertKit, vraagt om API key & API secret. Test HTTP request.)
- Tab op settings page: Integrations (voor integreren met Comment Form, Registration Form, WooCommerce & Contact Form 7, zie MC4WP > Integrations code voor inspiratie) 
- Gutenberg block voor toevoegen van ConvertKit aan post/page/... Laad beschikbare ConvertKit formulieren op via `get_transient()` zodat editor snel blijft laden.

### Should:
- Tab op settings page: Tools (voor debug log met errors & events, zoals bij MC4WP)

## Development

The `composer.json` is used for development only please do not use any auto loaders in the plugin.

### Getting started

Everything is inside this repository.

### Development Requirements

- [PHP >= 7.4](https://www.php.net/downloads.php#v7.4.6)
- [Composer](https://getcomposer.org/)
- [Node JS >= 14](https://nodejs.org/)
- [Wordpress >= 5](https://nl.wordpress.org/download/)

#### PHP Unit

In order to use PHP unit copy the file `phpunit.xml.dist` to `phpunit.xml`

### Composer scripts

- `phpunit:test` runs all the tests and uses the `phpunit.xml` for the configuration.
- `phpcs:sniff` check all the php files against the rules described in `phpcs.xml`
- `phpcs:fix` fix all the files to the rules described in `phpcs.xml`

### NPM scripts

- `webpack:watch` watch changes from the `webpack.common.js`
- `webpack:hot` see the section bellow for the usage
- `eslint:sniff` sniff the code style against the rules described in `.eslint`
- `eslint:fix` fix code according to the rules described in `.eslint`  

#### Webpack HRM (hot reload module)

Why? To speed up the development, so you don't have to reload the browser window manually over and over again.

To enable webpack HRM copy the `webpack.hrm.js.dist` to `webpack.hrm.js` fill in with your credentials.

- run `$ npm run webpack:hot`