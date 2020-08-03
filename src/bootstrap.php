<?php
/**
 * bootstrap common.
 */
require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/functions.php';
require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/helpers.php';
require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/core/hooks/interface-hooks.php';
require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/core/hooks/interface-hooker.php';
require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/core/hooks/class-hooks-service.php';

//Require integrations to be load
require UNOFFICIAL_CONVERTKIT_SRC_DIR . '/integrations/bootstrap.php';
