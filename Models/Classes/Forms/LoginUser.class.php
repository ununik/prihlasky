<?php
class Forms_LoginUser
{
    private $_login = '';
    private $_previousPassword = '';
    private $_newPassword = '';
    private $_newPasswordAgain = '';
    private $_errors = array();
    private $_correctForm = false;
    private $_passwordChange = false;
    
    public function __construct()
    {
        $this->_login = User::$user['login'];
    }
    
    public function setLogin($login)
    {
        $this->_login = \Library\Helpers\safeText($login);
    }
    public function getLogin()
    {
        return $this->_login;
    }
    
    public function setPreviousPassword($password)
    {
        $this->_previousPassword = \Library\Helpers\safeText($password);
    }
    public function setNewPassword($password)
    {
        $this->_newPassword = \Library\Helpers\safeText($password);
    }
    public function setNewPasswordAgain($password)
    {
        $this->_newPasswordAgain = \Library\Helpers\safeText($password);
    }
    
    public function validateData()
    {
        if (strlen($this->_login) == 0) {
            $this->_errors['login'][] = 'Není vyplněný login.';
        } else if (strlen($this->_login) > 255) {
            $this->_errors['login'][] = 'Vyplněný login je příliš dlouhý.';
        }
        
        if (
            strlen($this->_newPassword) > 0
            || strlen($this->_newPasswordAgain) > 0
            || strlen($this->_previousPassword) > 0
        ) {
            $this->_passwordChange = true;
            if (strlen($this->_previousPassword) == 0) {
                $this->_errors['previousPassword'][] = 'Není vyplněné heslo.';
            } else if (\Library\Password\passwordHash($this->_previousPassword) != User::$user['password']) {
                $this->_errors['previousPassword'][] = 'Špatné původní heslo.';
            }
            
            if ($this->_newPassword != $this->_newPasswordAgain || strlen($this->_newPassword) != strlen($this->_newPasswordAgain)) {
                $this->_errors['newPassword'][] = 'Nové heslo se liší od jeho kontroly.';
            } else if (strlen($this->_newPassword) == 0) {
                $this->_errors['newPassword'][] = 'Není vyplněné heslo.';
            } else if (strlen($this->_newPassword) < 4) {
                $this->_errors['newPassword'][] = 'Heslo musí mít minimálně 4 znaky.';
            }
        }
        
        if (count($this->_errors) == 0) {
            $this->updateLoginData();
            
            $this->_correctForm = true;
            
            header('Location: '.Page::getPageLink(6, 'login-update'));
        }
    }
    
    private function updateLoginData()
    {
        $values['login'] = $this->_login;
        
        if ($this->_passwordChange) {
            $values['password'] = \Library\Password\passwordHash($this->_newPassword);
        }
        
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
    
    public function getClassForLogin()
    {
        if (isset($this->_errors['login'])) {
            return 'error';
        }
    
        return '';
    }
    
    public function getClassForOldPassword()
    {
        if (isset($this->_errors['previousPassword'])) {
            return 'error';
        }
    
        return '';
    }
    
    public function getClassForNewPassword()
    {
        if (isset($this->_errors['newPassword'])) {
            return 'error';
        }
    
        return '';
    }
}