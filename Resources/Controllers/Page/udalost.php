<?php
$nadpis = 'Nová událost';
$udalostForm = new Forms_Udalost();
if (Page::getAdditionalMessage() != '') {
    $udalostClass = new Udalost();
    
    $event = $udalostClass->getUdalostFromSlugName(Page::getAdditionalMessage());
    if ($event != false) {
        $nadpis = $event['title'];
        $udalostForm = new Forms_Udalost($event);
    }
}

if (isset($_POST['udalost_submit'])) {
    $udalostForm->setNazev($_POST['title']);
    $udalostForm->setUdalostDate($_POST['date']);
    $udalostForm->setEmail($_POST['email']);
    $udalostForm->setPrezentace($_POST['prezentace']);
    $udalostForm->setStart($_POST['start']);
    $udalostForm->setCil($_POST['cil']);
    
    if (isset($_POST['prihlasky'])) {
        $udalostForm->setPrihlasky(true);
    } else {
        $udalostForm->setPrihlasky(false);
    }
    
    $udalostForm->validateData();
}