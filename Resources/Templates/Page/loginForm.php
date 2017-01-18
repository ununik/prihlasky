<?php
$container = '<h1>Přihlášení</h1>';

if (count($loginForm->getErrors()) > 0) {
    $container .= $loginForm->getErrorList();
}

$container .= '<form action="" method="post">';

$container .= '<div class="form_input_div '.$loginForm->getClassForLogin().'">';
$container .= '<label for="login">Login</label>';
$container .= '<input type="text" id="login" name="login" value="'.$loginForm->getLogin().'"/>';
$container .= '</div>';

$container .= '<div class="form_input_div '.$loginForm->getClassForPassword().'">';
$container .= '<label for="password">Heslo</label>';
$container .= '<input type="password" id="password" name="password" />';
$container .= '</div>';

$container .= '<div class="form_submit_div">';
$container .= '<input type="submit" id="submit" name="login_submit" value="Přihlásit" />';
$container .= '</div>';

$container .= '</form>';


return $container;