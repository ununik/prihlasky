<?php
unset($_SESSION[\Conf\Sessions\BE_USER]);

header('Location: '.Page::getPageLink(1));