<?php
$prihlasky = Database::selectFromTable('*', 'events', '', '', 'udalost_timestamp', true);