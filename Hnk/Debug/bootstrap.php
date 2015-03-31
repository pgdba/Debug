<?php

define('APP_DIR', __DIR__);
define('BASE_DIR', dirname(dirname(APP_DIR)));

require_once APP_DIR . '/autoload.php';
require_once APP_DIR . '/helpers.php';

if (!defined('HNK_DEBUG_MODE')) {
    define('HNK_DEBUG_MODE', \Hnk\Debug\Config\ConfigInterface::MODE_OFF);
}

