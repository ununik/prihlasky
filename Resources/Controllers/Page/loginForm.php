<?php
$loginForm = new Forms_Login();
if (isset($_POST['login_submit'])) {
    $login = $loginForm->setLogin($_POST['login']);
    $password = $loginForm->setPassword($_POST['password']);
    
    $loginForm->ValidateData();
    
    if ($loginForm->correctLogin()) {
        header('Location: '.Page::getPageLink(2));
    }
}