<?php
class Forms_Nastaveni
{
    private $_webName;
    private $_errors = array();
    private $_correctForm = false;
    private $_dateFormat = '';
    private $_timeFormat = '';
    
    public function __construct()
    {
        $this->_webName = $GLOBALS['webInfo']['web_name'];
        $this->_dateFormat = $GLOBALS['webInfo']['date_format'];
        $this->_timeFormat = $GLOBALS['webInfo']['time_format'];
    }
    
    public function getWebName()
    {
        return $this->_webName;
    }
    
    public function setWebName($name)
    {
        $this->_webName = \Library\Helpers\safeText($name);
    }
    
    public function validateData()
    {        
        if (count($this->_errors) == 0) {
            $this->saveData();
            
            header('Location: '.Page::getPageLink(8, 'ulozeno'));
        }
    }
    
    public function setDateFormat($format)
    {
        $this->_dateFormat = \Library\Helpers\safeText($format);
    }
    
    public function getDateFormat()
    {
        return $this->_dateFormat;
    }
    
    public function setTimeFormat($format)
    {
        $this->_timeFormat = \Library\Helpers\safeText($format);
    }
    
    public function getTimeFormat()
    {
        return $this->_timeFormat;
    }
    
    private function saveData()
    {
        $data = $GLOBALS['webInfo'];
        $data['web_name'] = $this->_webName;
        $data['date_format'] = $this->_dateFormat;
        $data['time_format'] = $this->_timeFormat;
        
        $save = "<?php\n";
        $save .= '$webInfo = ' . var_export($data, true).';';
        
        $confFile = fopen(HOME_DIR . \Conf\Paths\WEB_INFO, "w");
        fwrite($confFile, $save);
        fclose($confFile);
    }
    
    public function getClassForDateForma()
    {
        if (isset($this->_errors['dateFormat'])) {
            return 'error';
        }
        
        return '';
    }
    public function getClassForTimeForma()
    {
        if (isset($this->_errors['timeFormat'])) {
            return 'error';
        }
    
        return '';
    }
    public function getErrors()
    {
        return $this->_errors;
    }
    
    public function getErrorList()
    {
        $return = '<ul class="errors">';
        foreach ($this->_errors as $error) {
            if (is_array($error)) {
                foreach ($error as $er) {
                    $return .= "<li>$er</li>";
                }
            } else {
                $return .= "<li>$error</li>";
            }
        }
        $return .= '</ul>';
    
        return $return;
    }
}