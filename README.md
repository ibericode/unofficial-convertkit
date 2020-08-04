![](https://github.com/ibericode/unofficial-convertkit/workflows/PHP/badge.svg)
[![License: GPLv3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

# Unofficial ConvertKit

Unofficial ConvertKit plugin for WordPress.


### Requirements

- [PHP >= 7.0](https://www.php.net/downloads.php#v7.4.6)
- [WordPress >= 5.0](https://nl.wordpress.org/download/)


### Installation

Clone the repository in your `wp-content/plugins` directory.

```
git clone git@github.com:ibericode/unofficial-convertkit.git wp-content/plugins/unofficial-convertkit
```


### Configuration

Go to **Settings > Unofficial ConvertKit > General** and fill your ConvertKit API key and Secret. You can get your API key and Secret here: https://app.convertkit.com/account/edit


### Composer scripts

- `phpunit:test` runs all the tests and uses the `phpunit.xml` for the configuration.
- `phpcs:sniff` check all the php files against the rules described in `phpcs.xml`
- `phpcs:fix` fix all the files to the rules described in `phpcs.xml`


### NPM scripts

- `webpack:dev:watch` watch changes from the `webpack.common.js`
- `webpack:dev:hot` see the section below for the usage
- `webpack:prod:build` build production assets
- `eslint:sniff` sniff the code style against the rules described in `.eslint`
- `eslint:fix` fix code according to the rules described in `.eslint`


### License

GPLv3 or later.
