![](https://github.com/ibericode/unofficial-convertkit/workflows/PHP/badge.svg)

# Unofficial ConvertKit

Unofficial ConvertKit plugin for WordPress.

## Plugin requirements

- PHP >= 7
- WordPress >= 5

## Installation and setup

You can clone this repository / download as zip file, and upload that zip file under Plugins > Add new > Upload into your WordPress admin.

The settings for this plugin can be found under Admin menu item: **Settings > Unofficial ConvertKit** once the plugin is activated.

### Configuration
- Go to **Settings > Unofficial ConvertKit > General** and fill your ConvertKit API key and Secret. Without this the integrations won't work.  You can get your API key and Secret here: https://app.convertkit.com/account/edit
- You can use the Gutenberg block to show a form in any page or post. While editing the page/post, click the + above the editor and search for ConvertKit. The block will let you choose from the forms you've already created in your COnvertKit account (not implemented yet, coming soon)
- Once API key and Secret are saved you can activate **Integrations** with the default WordPress Comment Form, Registration Form, WooCommerce checkout & Contact Form 7.


### Coming soon:
- Gutenberg block to show a form
- Tab op settings page: Tools (voor debug log met errors & events, zoals bij MC4WP)
- Lots of amazing features

## Development

The `composer.json` is used for development only please do not use any auto loaders in the plugin.

### Development Requirements

- [PHP >= 7.4](https://www.php.net/downloads.php#v7.4.6)
- [Composer](https://getcomposer.org/)
- [Node JS >= 14](https://nodejs.org/)
- [WordPress >= 5](https://nl.wordpress.org/download/)

#### PHP Unit

In order to use PHP unit copy the file `phpunit.xml.dist` to `phpunit.xml`

### Composer scripts

- `phpunit:test` runs all the tests and uses the `phpunit.xml` for the configuration.
- `phpcs:sniff` check all the php files against the rules described in `phpcs.xml`
- `phpcs:fix` fix all the files to the rules described in `phpcs.xml`

### NPM scripts

- `webpack:dev:watch` watch changes from the `webpack.common.js`
- `webpack:dev:hot` see the section bellow for the usage
- `webpack:prod:build` build production assets
- `eslint:sniff` sniff the code style against the rules described in `.eslint`
- `eslint:fix` fix code according to the rules described in `.eslint`

#### Webpack HRM (hot reload module)

Why? To speed up the development, so you don't have to reload the browser window manually over and over again.
Note: I't may break your gutenberg editor a little bit
- run `$ npm run webpack:dev:hot`
