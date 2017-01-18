<?php
namespace Library\Autoload;

function loadClass($className)
{
    $path = str_replace('_', '/', $className);
    
    require_once HOME_DIR . \Conf\Paths\CLASSES_PATH . '/' . $path . '.class.php';
}

function url($file){
    $url =  sprintf(
        "%s://%s%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],
        $file//$_SERVER['REQUEST_URI']
    );
    
    if (in_array('mod_rewrite', apache_get_modules())) {
        $url = substr($url, 0, -10);
    }
    
    return $url;
}