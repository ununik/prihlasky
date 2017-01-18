<?php
class HTML
{
    public function __construct()
    {
        $this->setHeaderTitle($GLOBALS['webInfo']['web_name']);
    }
    public function getHtml()
    {
        $return = '<!DOCTYPE html>';
        
        $return .= '<html>';
        $return .= $this->getHeader();
        $return .= $this->getBody();
        $return .= '</html>';
        
        return $return;
    }
    
//HEADER   
    private function getHeader()
    {
        $return = '<head>';
        $return .= '<meta charset="utf-8">';
        $return .= $this->getHeaderTitle();
        $return .= '</head>';
        
        return $return;
    }
    
    private $_header_title = '';
    public function setHeaderTitle($new)
    {
        if ($new != '') {
            $this->_header_title = $new . ' | ' . $GLOBALS['webInfo']['web_name'];
        } else {
            $this->_header_title = $GLOBALS['webInfo']['web_name'];
        }
    }
    private function getHeaderTitle()
    {
        return "<title>{$this->_header_title}</title>";
    }

//BODY    
    private function getBody()
    {
        $return = '<body>';
        $return .= $this->getBodyContent();
        $return .= '</body>';
        
        return $return;
    }
    
    static private $_body_content = '';
    public function addToBodyContent($new = '', $controllers = '', $views = '')
    {
        if (is_array($controllers)) {
            foreach ($controllers as $controller) {
                include $controller;
            }
        } else if ($controllers != '') {
            include $controllers;
        }
        
        if ($new != '') {
            HTML::$_body_content .= $new;
        }
        
        if (is_array($views)) {
            foreach ($views as $view) {
                HTML::$_body_content .= include $view;
            }
        } else if ($views != '') {
            HTML::$_body_content .= include $views;
        }
    }
    private function getBodyContent()
    {
        return HTML::$_body_content;
    }
}