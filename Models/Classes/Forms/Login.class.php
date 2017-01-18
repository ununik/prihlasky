<?php
class Forms_Login
{
    private $_login = '';
    private $_password = '';
    private $_errors = array();
    private $_correctForm = false;
    
    public function correctLogin()
    {
        return $this->_correctForm;
    }
    
    public function getLogin()
    {
        return $this->_login;
    }
    
    public function setLogin($login)
    {
        $this->_login = \Library\Helpers\safeText($login);
    }
    
    public function setPassword($password)
    {
        $this->_password = \Library\Helpers\safeText($password);
    }
    
    public function ValidateData()
    {
        if (strlen($this->_login) == 0) {
            $this->_errors['login'][] = 'Není vyplněný login';
        }
        
        if (strlen($this->_password) == 0) {
            $this->_errors['password'][] = 'Není vyplněné heslo';
        }
        
        if (count($this->_errors) == 0) {
            $this->checkLoginData();
        }
        
        return $this->_correctForm;
    }
    
    private function checkLoginData()
    {
        $users = Database::selectFromTable('id', 'users', 'login = "'. $this->_login . '" AND password = "' . \Library\Password\passwordHash($this->_password) . '"', 1);
        
        if (!isset($users['id'])) {
            $this->_errors['loginAndPassword'][] = 'Vyplněný login nebo heslo nejsou správné';
        } else {
            $_SESSION[\Conf\Sessions\BE_USER] = $users['id'];
            $this->_correctForm = true;
        }
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
    
    public function getClassForLogin()
    {
        if (isset($this->_errors['login']) || isset($this->_errors['loginAndPassword'])) {
            return 'error';
        }
        
        return '';
    }
    
    public function getClassForPassword()
    {
        if (isset($this->_errors['password']) || isset($this->_errors['loginAndPassword'])) {
            return 'error';
        }
        
        return '';
    }
}