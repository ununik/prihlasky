<?php
$container = '<div class="admin_user_panel">';
$container .= '<a href="'.Page::getPageLink(2).'">';
$container .= User::getName();
$container .= '</a>';
$container .= '</div>';

return $container;