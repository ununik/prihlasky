<?php
const HOME_DIR = __DIR__;

//PATHs
require_once HOME_DIR . '/Resources/Configuration/paths.php';

require_once HOME_DIR . \Conf\Paths\LIBRARY_AUTOLOAD;
require_once HOME_DIR . \Conf\Paths\CONNECTION;


//Autoload classes
spl_autoload_register('\Library\Autoload\loadClass');