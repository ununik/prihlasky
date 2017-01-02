<?php
namespace Library\Autoload;

function loadClass($className)
{
    $path = str_replace('_', '/', $className);
    
    require_once HOME_DIR . \Conf\Paths\CLASSES_PATH . '/' . $path . '.class.php';
}