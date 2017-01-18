<?php
class Udalost
{
    public function getUdalostFromSlugName($slugName)
    {
        $event = Database::selectFromTable('*', 'events', '`slug-name` = "'.$slugName.'"', 1);
        
        if (!isset($event['id'])) {
            return false;
        }
        
        return $event;
    }
}