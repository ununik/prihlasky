<?php
class HTML
{
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
        $return .= $this->getHeaderTitle();
        $return .= '</head>';
        
        return;
    }
    
    private $_header_title = 'TEST';
    public function setHeaderTitle($new)
    {
        $this->_header_title = $new;
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
    
    private $_body_content = '';
    public function addToBodyContent($new)
    {
        $this->_body_content .= $new;
    }
    private function getBodyContent()
    {
        return $this->_body_content;
    }
}