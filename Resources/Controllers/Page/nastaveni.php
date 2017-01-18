<?php
$message = '';
switch (Page::getAdditionalMessage()) {
    case 'ulozeno':
        $message = '<ul class="messages"><li>Změny byly uloženy. (Změny se projeví později (případně aktualizuj stránku, dokud se změna neprojeví))</li></ul>';
        break;
}

$nastaveniForm = new Forms_Nastaveni();

if (isset($_POST['nastaveniForm_submit'])) {
    $nastaveniForm->setWebName($_POST['webName']);
    $nastaveniForm->setDateFormat($_POST['dateFormat']);
    $nastaveniForm->setTimeFormat($_POST['timeFormat']);
    
    $nastaveniForm->validateData();
}