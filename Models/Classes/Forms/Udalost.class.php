<?php
class Forms_Udalost
{
    private $_new = true;
    private $_errors = array();
    private $_correctForm = false;    
    private $_nazev = '';
    private $_slugName = '';
    private $_slugPostfix = '';
    private $_id = 0;
    
    private $_udalostDatum_string = '';
    private $_datumUdalost = 0; 
    private $_email = '';
    private $_prihlasky = 0;
    
    private $_prezentace_string = '';
    private $_prezentace_N = 0;
    private $_prezentace_E = 0;
    
    private $_start_string = '';
    private $_start_N = 0;
    private $_start_E = 0;
    
    private $_cil_string = '';
    private $_cil_N = 0;
    private $_cil_E = 0;
    
    public function __construct($data = '')
    {
        $this->_datumUdalost = time();
        $this->_email = User::$user['email'];
        
        if ($data != '') {
            $this->_new = false;
            
            $this->_id = $data['id'];
            
            $this->_nazev = $data['title'];
            $this->_slugName = $data['slug-name'];
            $this->_datumUdalost = $data['udalost_timestamp'];
            $this->_email = $data['email'];
            $this->_prihlasky = $data['prihlasky'];
            $this->_prezentace_N = $data['prezentace_gps_N'];
            $this->_prezentace_E = $data['prezentace_gps_E'];
            $this->_start_N = $data['start_gps_N'];
            $this->_start_E = $data['start_gps_E'];
            $this->_cil_N = $data['cil_gps_N'];
            $this->_cil_E = $data['cil_gps_E'];
        }
    }    
    public function setNazev($nazev)
    {
        $this->_nazev = \Library\Helpers\safeText($nazev);
        
        $this->setSlugName();
    }
    public function getNazev()
    {
        return $this->_nazev;
    }
    
    public function setSlugName()
    {
        $this->_slugName = \Library\Helpers\slugify($this->_nazev);
        
        $this->checkFreeSlugName();        
    }
    
    public function getFullSlugName()
    {
        if ($this->_slugPostfix != '') {
            return $this->_slugName.'-'.$this->_slugPostfix;
        } else {
            return $this->_slugName;
        }
    }
    
    public function checkFreeSlugName()
    {
        $slug = Database::selectFromTable('id', 'events', 'id != '.$this->_id.' AND `slug-name` = "'.$this->getFullSlugName().'"', 1);
        
        if (isset($slug['id'])) {
            if (is_integer($this->_slugPostfix)) {
                $this->_slugPostfix = $this->_slugPostfix + 1;
            } else {
                $this->_slugPostfix = 1;
            }
            
            $this->checkFreeSlugName();
        }
    }
    
    public function validateData()
    {
        if (strlen($this->_nazev) == 0) {
            $this->_errors['nazev'] = 'Není vyplněný název';
        } else if (strlen($this->_nazev) > 250) {
            $this->_errors['nazev'] = 'Vyplněný název je příliš dlouhý';
        }
        
        $this->_datumUdalost = strtotime($this->_udalostDatum_string);
        if (strlen($this->_udalostDatum_string) == 0) {
            $this->_errors['datumUdalosti'] = 'Není vyplněný datum. Použij formát:'.$GLOBALS['webInfo']['date_format'];
        } else if ($this->_datumUdalost == 0) {
            $this->_errors['datumUdalosti'] = 'Špatně vyplněný datum. Použij formát:'.$GLOBALS['webInfo']['date_format'];
        }
        
        if (!\Library\Helpers\checkEmailFormat($this->_email) && strlen($this->_email) > 0) {
            $this->_errors['email'][] = 'Špatný formát emailu.';
        }
        
        $gpsPrezentace = \Library\Helpers\getGPSFromString($this->_prezentace_string); 
        if ($this->_prezentace_string != '' && $gpsPrezentace === false) {
            $this->_errors['prezentace'][] = 'Špatný formát GPS.';
        } else {
            $this->_prezentace_N = $gpsPrezentace['N'];
            $this->_prezentace_E = $gpsPrezentace['E'];
        }
        
        $gpsStart = \Library\Helpers\getGPSFromString($this->_start_string);
        if ($this->_start_string != '' && $gpsStart === false) {
            $this->_errors['start'][] = 'Špatný formát GPS.';
        } else {
            $this->_start_N = $gpsStart['N'];
            $this->_start_E = $gpsStart['E'];
        }
        
        $gpsCil = \Library\Helpers\getGPSFromString($this->_cil_string);
        if ($this->_cil_string != '' && $gpsCil === false) {
            $this->_errors['cil'][] = 'Špatný formát GPS.';
        } else {
            $this->_cil_N = $gpsCil['N'];
            $this->_cil_E = $gpsCil['E'];
        }
        
        if (count($this->_errors) == 0) {
            $this->saveData();
            
            header('Location: '.Page::getPageLink(11, $this->getFullSlugName()));
        }
    }
    
    public function saveData()
    {
        $values['title'] = $this->_nazev;
        $values['slug-name'] = $this->getFullSlugName();
        $values['udalost_timestamp'] = $this->_datumUdalost;
        $values['email'] = $this->_email;
        $values['prihlasky'] = $this->_prihlasky;
        $values['prezentace_gps_N'] = $this->_prezentace_N;
        $values['prezentace_gps_E'] = $this->_prezentace_E;
        $values['start_gps_N'] = $this->_start_N;
        $values['start_gps_E'] = $this->_start_E;
        $values['cil_gps_N'] = $this->_cil_N;
        $values['cil_gps_E'] = $this->_cil_E;
        
        if ($this->_new) {
            print_r(Database::insertIntoTable($values, 'events'));
        }
        
        return Database::updateTable($values, 'events', 'id = '.$this->_id);
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
    
    public function getClassForTitle()
    {
        if (isset($this->_errors['nazev'])) {
            return 'error';
        }
        
        return '';
    }
    
    public function setUdalostDate($string)
    {
        $this->_udalostDatum_string = \Library\Helpers\safeText(str_replace(' ', '', $string));
    }
    public function getDatumUdalosti()
    {
        return date($GLOBALS['webInfo']['date_format'], $this->_datumUdalost);
    }
    public function getClassForDatumUdalosti()
    {
        if (isset($this->_errors['datumUdalosti'])) {
            return 'error';
        }
        
        return '';
    }
    
    public function setEmail($email)
    {
        $this->_email = \Library\Helpers\safeText($email);
    }
    public function getEmail()
    {
        return $this->_email;
    }
    public function getClassForEmail()
    {
        if (isset($this->_errors['email'])) {
            return 'error';
        }
    
        return '';
    }
    
    public function setPrihlasky($boolean)
    {
        if ($boolean) {
            $this->_prihlasky = 1;
        } else {
            $this->_prihlasky = 0;
        }
    }
    public function getPrihlasky()
    {
        if ($this->_prihlasky == 1) {
            return 'checked';
        }
        return '';
    }
    
    public function setPrezentace($prezentace)
    {
        $this->_prezentace_string = \Library\Helpers\safeText($prezentace);
    }
    
    public function getPrezentace()
    {
        if ($this->_prezentace_N == 0 || $this->_prezentace_E == 0) {
            return $this->_prezentace_string;
        }
        return "{$this->_prezentace_N}N, {$this->_prezentace_E}E";
    }
    public function getClassForPrezentace()
    {
        if (isset($this->_errors['prezentace'])) {
            return 'error';
        }
    
        return '';
    }
    
    public function setStart($start)
    {
        $this->_start_string = \Library\Helpers\safeText($start);
    }
    
    public function getStart()
    {
        if ($this->_start_N == 0 || $this->_start_E == 0) {
            return $this->_start_string;
        }
        return "{$this->_start_N}N, {$this->_start_E}E";
    }
    public function getClassForStart()
    {
        if (isset($this->_errors['start'])) {
            return 'error';
        }
    
        return '';
    }
    
    public function setCil($cil)
    {
        $this->_cil_string = \Library\Helpers\safeText($cil);
    }
    
    public function getCil()
    {
        if ($this->_cil_N == 0 || $this->_cil_E == 0) {
            return $this->_start_string;
        }
        return "{$this->_cil_N}N, {$this->_cil_E}E";
    }
    public function getClassForCil()
    {
        if (isset($this->_errors['cil'])) {
            return 'error';
        }
    
        return '';
    }
}