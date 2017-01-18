<?php
class Forms_CreateUser extends User
{
    private $_login = '';
    private $_errors = array();
    private $_correctForm = false;
    private $_password = '';
    private $_passwordAgain = '';
    private $_messages = array();
    
    public function getLogin()
    {
        return $this->_login;
    }
    
    public function setLogin($login)
    {
        $this->_login = \Library\Helpers\safeText($login);
    }
    
    public function setPasswordAgain($password)
    {
        $this->_passwordAgain = $password;
    }
    
    public function setPassword($password)
    {
        $this->_password = $password;
    }
    
    public function validateData()
    {
        if (strlen($this->_login) == 0) {
            $this->_errors['login'][] = 'Není vyplněný login.';
        } else if (strlen($this->_login) > 255) {
            $this->_errors['login'][] = 'Vyplněný login je příliš dlouhý.';
        }
        
        $this->existLogin();
        
        if ($this->_password != $this->_passwordAgain) {
            $this->_errors['password'][] = 'Heslo a neodpovídá ověření hesla. Obě hesla musí být stejná.';
        } else if (strlen($this->_password) == 0) {
            $this->_errors['password'][] = 'Heslo není vyplněné.';
        } else if (strlen($this->_password) < 4) {
            $this->_errors['password'][] = 'Heslo musí mít minimálně 4 znaky.';
        }
        
        if (count($this->_errors) == 0) {
            $lastId = $this->addNewUser();
            if ($lastId == 0) {
                $this->_errors[] = 'Nastala chyba při ukládání.';
            } else {
                header('Location: '.Page::getPageLink(6, 'new-user'));
            }
        }
    }
    
    private function existLogin()
    {
        $user = Database::selectFromTable('id', 'users', 'login = "'. $this->_login . '"', 1);
        
        if (isset($users['id'])) {
            $this->_errors['login'][] = 'Vyplněný login je už obsazený.';
            return true;
        }
        
        return false;
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
    
    public function getMessages()
    {
        return $this->_messages;
    }
    
    public function getMessageList()
    {
        $return = '<ul class="messages">';
        foreach ($this->_messages as $message) {
            $return .= "<li>$message</li>";
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
    
    public function getClassForPassword()
    {
        if (isset($this->_errors['password'])) {
            return 'error';
        }
    
        return '';
    }
    
    private function addNewUser()
    {
        $values['login'] = $this->_login;
        $values['password'] = \Library\Password\passwordHash($this->_password);
        
        return Database::insertIntoTable($values, 'users');
    }
}