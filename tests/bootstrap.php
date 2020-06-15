<?php
/**
 * @var $loader ClassLoader
 */

use Composer\Autoload\ClassLoader;
use UnofficialConvertKit\Validator_Interface;

$loader = require __DIR__ . '/../vendor/autoload.php';

WP_Mock::bootstrap();

define( 'UNOFFICIAL_CONVERTKIT_VERSION', '0.0.0' );
define( 'UNOFFICIAL_CONVERTKIT', 'unofficial-convertkit' );
define( 'UNOFFICIAL_CONVERTKIT_PLUGIN_DIR', __DIR__ . '/..' );
define( 'UNOFFICIAL_CONVERTKIT_SRC_DIR', __DIR__ . '/../src' );

$loader->addClassMap(
	array(
		UNOFFICIAL_CONVERTKIT_SRC_DIR . '/validators/settings/class-general-validator.php' => UnofficialConvertKit\Validation_Error::class,
		UNOFFICIAL_CONVERTKIT_SRC_DIR . '/validators/interface-validator.php' => Validator_Interface::class,
	)
);

$loader->loadClass( Validator_Interface::class );
$loader->loadClass( UnofficialConvertKit\Validation_Error::class );

$loader->register();


