<?php
$container = '<h2>Seznam událostí</h2>';

foreach ($prihlasky as $udalost) {
    $container .= '<div class="prihlaska">';
    $container .= '<a href="'.Page::getPageLink(11, $udalost['slug-name']).'">'.$udalost['title'].' '.date($GLOBALS['webInfo']['date_format'], $udalost['udalost_timestamp']).'</a>';
    $container .= '</div>';
}

return $container;