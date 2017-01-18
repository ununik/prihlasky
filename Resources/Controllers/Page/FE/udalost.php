<?php
$udalostClass = new Udalost();
$udalost = $udalostClass->getUdalostFromSlugName(Page::getAdditionalMessage());
if (!$udalost) {
    header('Location: '.Page::getPageLink(13));
}