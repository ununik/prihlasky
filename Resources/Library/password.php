<?php
namespace Library\Password;

function passwordHash($password)
{
    return md5('prihlaska'.$password);
}