<?php
class User
{
    static $user;
    
    public function checkId($id)
    {
        $user = Database::selectFromTable('*', 'users', 'id = '. $id, 1);
        
        if (!isset($user['id'])) {
            header('Location: '.Page::getPageLink(5));
        } 
        
        User::$user = $user;
    }
    
    public function getName($user = '')
    {
        if ($user == '') {
            $user = User::$user;
        }
        
        if ($user['name'] != '') {
            return $user['name'];
        }
        if ($user['email'] != '') {
            return $user['email'];
        }
        
        return $user['login'];
    }
    
    public function getAllUsers()
    {
        $users = Database::selectFromTable('*', 'users', '', '', 'login', true);
        
        return $users;
    }
}