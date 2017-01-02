<?php
require_once __DIR__ .'/autoload.php';

$html = new HTML();

$pagePath = new Page_Path();

$html->addToBodyContent('test123');

print $html->getHtml();