<?php
require_once __DIR__ .'/autoload.php';
$html = new HTML();
$page = new Page();

$html->setHeaderTitle($page->getTitle());
$html->addToBodyContent($page->getNavigation());
$html->addToBodyContent('', $page->getPageControllers(), $page->getPageViews());

print $html->getHtml();