<?php
$container = '<h2>'.User::getName().'</h2>';

$container .= $message;

$container .= '<ul class="menuList">';
$container .= '<li>Detail</li>';
$container .= '<li>Přihlašovací údaje</li>';
$container .= '<li>Seznam uživatelů</li>';
$container .= '</ul>';


$container .= '<div id="detailForm">';

$container .= '<h3>Detail</h3>';
if (count($detailUserForm->getErrors()) > 0) {
    $container .= $detailUserForm->getErrorList();
}
$container .= '<form action="" method="post">';

$container .= '<div class="form_input_div '.$detailUserForm->getClassForName().'">';
$container .= '<label for="name">Jméno</label>';
$container .= '<input type="text" id="name" name="name" value="'.$detailUserForm->getName().'"/>';
$container .= '</div>';

$container .= '<div class="form_input_div '.$detailUserForm->getClassForEmail().'">';
$container .= '<label for="email">Email</label>';
$container .= '<input type="text" id="email" name="email" value="'.$detailUserForm->getEmail().'"/>';
$container .= '</div>';


$container .= '<div class="form_submit_div">';
$container .= '<input type="submit" id="submit" name="detailForm_submit" value="Uložit" />';
$container .= '</div>';

$container .= '</form>';

$container .= '</div>';
/////////////////////////////////////////////////////////////////////////////////////////
$container .= '<div id="loginForm">';

$container .= '<h3>Přihlašovací údaje</h3>';
if (count($loginUserForm->getErrors()) > 0) {
    $container .= $loginUserForm->getErrorList();
}
$container .= '<form action="" method="post">';

$container .= '<div class="form_input_div '.$loginUserForm->getClassForLogin().'">';
$container .= '<label for="login">Login</label>';
$container .= '<input type="text" id="login" name="login" value="'.$loginUserForm->getLogin().'"/>';
$container .= '</div>';

$container .= '<div class="form_input_div '.$loginUserForm->getClassForOldPassword().'">';
$container .= '<label for="passwordPrevious">Původní heslo</label>';
$container .= '<input type="password" id="passwordPrevious" name="passwordPrevious" />';
$container .= '</div>';

$container .= '<div class="form_input_div '.$loginUserForm->getClassForNewPassword().'">';
$container .= '<label for="password">Nové heslo</label>';
$container .= '<input type="password" id="password" name="password" />';
$container .= '</div>';

$container .= '<div class="form_input_div '.$loginUserForm->getClassForNewPassword().'">';
$container .= '<label for="passwordAgain">Heslo znovu</label>';
$container .= '<input type="password" id="passwordAgain" name="passwordAgain" />';
$container .= '</div>';

$container .= '<div class="form_submit_div">';
$container .= '<input type="submit" id="submit" name="loginForm_submit" value="Uložit" />';
$container .= '</div>';

$container .= '</form>';

$container .= '</div>';
///////////////////////////////////////////////////////////////////////////////////////
$container .= '<div id="newUserForm">';

$container .= '<h3>Seznam uživatelů</h3>';

if (User::$user['pravomoc_create_users'] == 1) {
    $container .= '<h4>Nový uživatel</h4>';
    
    if (count($newUserForm->getErrors()) > 0) {
        $container .= $newUserForm->getErrorList();
    }
    if (count($newUserForm->getMessages()) > 0) {
        $container .= $newUserForm->getMessageList();
    }
    
    $container .= '<form action="" method="post">';
    
    $container .= '<div class="form_input_div '.$newUserForm->getClassForLogin().'">';
    $container .= '<label for="login">Login</label>';
    $container .= '<input type="text" id="login" name="login" value="'.$newUserForm->getLogin().'"/>';
    $container .= '</div>';
    
    $container .= '<div class="form_input_div '.$newUserForm->getClassForPassword().'">';
    $container .= '<label for="password">Heslo</label>';
    $container .= '<input type="password" id="password" name="password" />';
    $container .= '</div>';
    
    $container .= '<div class="form_input_div '.$newUserForm->getClassForPassword().'">';
    $container .= '<label for="passwordAgain">Heslo znovu</label>';
    $container .= '<input type="password" id="passwordAgain" name="passwordAgain" />';
    $container .= '</div>';
    
    $container .= '<div class="form_submit_div">';
    $container .= '<input type="submit" id="submit" name="newUser_submit" value="Vytvořit" />';
    $container .= '</div>';
    
    $container .= '</form>';

}

$container .= '<table>';

foreach (User::getAllUsers() as $user) {
    $container .= '<tr>';
    $container .= '<td>'.User::getName($user).'</td>';
    if (User::$user['pravomoc_delete_users']) {
        $container .= '<td>';
        if (User::$user['id'] != $user['id']) {
            $container .= '<a href="'.Page::getPageLink(7, $user['login']).'">smazat</a>';
        }
        $container .= '</td>';
    }
    $container .= '</tr>';
}
$container .= '</table>';

$container .= '</div>';

return $container;