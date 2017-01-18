<?php
class Forms_DetailUser
{
    private $_name;
    private $_email;
    private $_errors = array();
    private $_correctForm = false;
    
    public function __construct()
    {
        $this->_name = User::$user['name'];
        $this->_email = User::$user['email'];
    }
    
    public function getName()
    {
        return $this->_name;
    }
    public function setName($name)
    {
        $this->_name = \Library\Helpers\safeText($name);
    }
    
    public function getEmail()
    {
        return $this->_email;
    }
    
    public function setEmail($email)
    {
        $this->_email = \Library\Helpers\safeText($email);
    }
    
    public function validateData()
    {
        if (strlen($this->_name) > 255) {
            $this->_errors['name'][] = 'Příliš dlouhé jméno.';
        }
        if (strlen($this->_email) > 255) {
            $this->_errors['email'][] = 'Příliš dlouhý email.';
        }
        if (!\Library\Helpers\checkEmailFormat($this->_email) && strlen($this->_email) > 0) {
            $this->_errors['email'][] = 'Špatný formát emailu.';
        }
        
        if (count($this->_errors) == 0) {
            $this->updateUser();
            
            $this->_correctForm = true;
            header('Location: '.Page::getPageLink(6, 'update-user'));
        }
    }
    
    public function updateUser()
    {
        $values['name'] = $this->_name;
        $values['email'] = $this->_email;
        
        Database::updateTable($values, 'users', 'id='.User::$user['id'], 1);
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
    
    public function getClassForName()
    {
        if (isset($this->_errors['name'])) {
            return 'error';
        }
    
        return '';
    }
    
    public function getClassForEmail()
    {
        if (isset($this->_errors['email'])) {
            return 'error';
        }
    
        return '';
    }
}