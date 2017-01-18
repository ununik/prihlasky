<?php
$container = '<h2>Nastavení</h2>';

$container .= $message;

if (count($nastaveniForm->getErrors()) > 0) {
    $container .= $nastaveniForm->getErrorList();
}

$container .= '<form action="" method="post">';

$container .= '<div class="form_input_div ">';
$container .= '<label for="webName">Název webu</label>';
$container .= '<input type="text" id="webName" name="webName" value="'.$nastaveniForm->getWebName().'"/>';
$container .= '</div>';

$container .= '<div class="form_input_div '.$nastaveniForm->getClassForDateForma().'">';
$container .= '<label for="dateFormat">Formát datumu</label>';
$container .= '<input type="text" id="dateFormat" name="dateFormat" value="'.$nastaveniForm->getDateFormat().'"/>';
$container .= '</div>';

$container .= '<div class="form_input_div '.$nastaveniForm->getClassForTimeForma().'">';
$container .= '<label for="timeFormat">Formát času</label>';
$container .= '<input type="text" id="timeFormat" name="timeFormat" value="'.$nastaveniForm->getTimeFormat().'"/>';
$container .= '</div>';

$container .= '<div class="form_submit_div">';
$container .= '<input type="submit" id="submit" name="nastaveniForm_submit" value="Uložit" />';
$container .= '</div>';

$container .= '</form>';

return $container;