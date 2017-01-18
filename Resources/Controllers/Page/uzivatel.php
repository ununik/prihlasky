<?php
$message = '';
switch (Page::getAdditionalMessage()) {
    case 'new-user':
        $message = '<ul class="messages"><li>Byl vytvořen nový uživatel.</li></ul>';
        break;
    case 'deleted-user':
        $message = '<ul class="messages"><li>Uživatel byl smazán.</li></ul>';
        break;
    case 'update-user':
        $message = '<ul class="messages"><li>Změna dat byla uložena.</li></ul>';
        break;
    case 'login-update':
        $message = '<ul class="messages"><li>Změna přihlašovacích dat byla uložena.</li></ul>';
        break;
}


$newUserForm = new Forms_CreateUser();
if (isset($_POST['newUser_submit'])) {
    $newUserForm->setLogin($_POST['login']);
    $newUserForm->setPassword($_POST['password']);
    $newUserForm->setPasswordAgain($_POST['passwordAgain']);
    
    $newUserForm->validateData();
}

$detailUserForm = new Forms_DetailUser();
if (isset($_POST['detailForm_submit'])) {
    $detailUserForm->setName($_POST['name']);
    $detailUserForm->setEmail($_POST['email']);
    
    $detailUserForm->validateData();
}


$loginUserForm = new Forms_LoginUser();
if (isset($_POST['loginForm_submit'])) {
    $loginUserForm->setLogin($_POST['login']);
    $loginUserForm->setPreviousPassword($_POST['passwordPrevious']);
    $loginUserForm->setNewPassword($_POST['password']);
    $loginUserForm->setNewPasswordAgain($_POST['passwordAgain']);
    
    $loginUserForm->validateData();
}