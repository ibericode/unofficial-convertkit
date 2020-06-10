<?php

define('ABSPATH',  realpath(__DIR__ . '/../../../../www/') . '/');

define('DB_NAME', 'wordpress_test');
define('DB_USER', 'homestead');
define('DB_PASSWORD', 'secret');
define('DB_HOST', '192.168.10.10');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

define('WP_DEBUG', true);
define('WP_TESTS_DOMAIN', 'example.org');
define('WP_TESTS_EMAIL', 'admin@example.org');
define('WP_TESTS_TITLE', 'Test Blog');
define('WPLANG', '');

define('WP_PHP_BINARY', 'php');

$table_prefix = 'wp_test';
