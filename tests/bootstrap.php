<?php

require __DIR__ . '/../vendor/autoload.php';

WP_Mock::bootstrap();

define( 'UNOFFICIAL_CONVERTKIT_VERSION', '0.0.0' );
define( 'UNOFFICIAL_CONVERTKIT', 'unofficial-convertkit' );
define( 'UNOFFICIAL_CONVERTKIT_PLUGIN_DIR', dirname( __DIR__ ) );
define( 'UNOFFICIAL_CONVERTKIT_SRC_DIR', dirname( __DIR__ ) . '/src' );


