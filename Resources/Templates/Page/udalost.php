<?php
$container = '<h2>'.$nadpis.'</h2>';

$container .= '<div class="path">URL: <a href="'.Page::getPageLink(12, $udalostForm->getFullSlugName()).'" target="_blank">'.Page::getPageLink(12, $udalostForm->getFullSlugName()).'</a></div>';

if (count($udalostForm->getErrors()) > 0) {
    $container .= $udalostForm->getErrorList();
}

$container .= '<form action="" method="post">';

$container .= '<div class="form_input_div  '.$udalostForm->getClassForTitle().'">';
$container .= '<label for="title">Název</label>';
$container .= '<input type="text" id="title" name="title" value="'.$udalostForm->getNazev().'"/>';
$container .= '</div>';

$container .= '<div class="form_input_div  '.$udalostForm->getClassForDatumUdalosti().'">';
$container .= '<label for="date">Datum události</label>';
$container .= '<input type="text" id="date" name="date" value="'.$udalostForm->getDatumUdalosti().'"/>';
$container .= '</div>';

$container .= '<div class="form_input_div  '.$udalostForm->getClassForEmail().'">';
$container .= '<label for="email">Email</label>';
$container .= '<input type="text" id="email" name="email" value="'.$udalostForm->getEmail().'"/>';
$container .= '</div>';

$container .= '<div class="form_input_div  '.$udalostForm->getClassForPrezentace().'">';
$container .= '<label for="prezentace">Prezentace (GPS ve formátu: xx.xxxxxN, xx.xxxxE)</label>';
$container .= '<input type="text" id="prezentace" name="prezentace" value="'.$udalostForm->getPrezentace().'"/>';
$container .= '</div>';

$container .= '<div class="form_input_div  '.$udalostForm->getClassForStart().'">';
$container .= '<label for="start">Start (GPS ve formátu: xx.xxxxxN, xx.xxxxE)</label>';
$container .= '<input type="text" id="start" name="start" value="'.$udalostForm->getStart().'"/>';
$container .= '</div>';

$container .= '<div class="form_input_div  '.$udalostForm->getClassForCil().'">';
$container .= '<label for="cil">Cíl (GPS ve formátu: xx.xxxxxN, xx.xxxxE)</label>';
$container .= '<input type="text" id="cil" name="cil" value="'.$udalostForm->getCil().'"/>';
$container .= '</div>';

$container .= '<div class="form_checkbox_div">';
$container .= '<label for="prihlasky">Prihlasky</label>';
$container .= '<input type="checkbox" id="prihlasky" name="prihlasky" '.$udalostForm->getPrihlasky().'/>';
$container .= '</div>';

$container .= '<div class="form_submit_div">';
$container .= '<input type="submit" id="submit" name="udalost_submit" value="Uložit" />';
$container .= '</div>';

$container .= '</form>';

return $container;