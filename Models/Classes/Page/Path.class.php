<?php
class Page_Path
{
    private $_paths = array();
    
    public function __construct()
    {
        if (isset($_SERVER['PATH_INFO'])) {
            $this->_paths = explode('/', $_SERVER['PATH_INFO']);  
        }
    }
}