<?php
if (User::$user['pravomoc_delete_users'] == 1) {
    Database::deleteRow('users', 'login = "'.Page::getAdditionalMessage().'"', 1);
}

header('Location: '.Page::getPageLink(6, 'deleted-user'));