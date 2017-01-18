<?php
session_start();
const HOME_DIR = __DIR__;

//PATHs
require_once HOME_DIR . '/Resources/Configuration/paths.php';

require_once HOME_DIR . \Conf\Paths\WEB_INFO;

require_once HOME_DIR . \Conf\Paths\LIBRARY_AUTOLOAD;
require_once HOME_DIR . \Conf\Paths\LIBRARY_HELPERS;
require_once HOME_DIR . \Conf\Paths\LIBRARY_PASSWORD;

require_once HOME_DIR . \Conf\Paths\CONNECTION;
require_once HOME_DIR . \Conf\Paths\SESSION_CONF;


//Autoload classes
spl_autoload_register('\Library\Autoload\loadClass');

define('HOME_URL', \Library\Autoload\url($_SERVER['SCRIPT_NAME']));