<?php

$routes[] = ['GET', '/Users/login', ['module' => 'Users', 'action' => 'login'], 'login'];
$routes[] = ['POST', '/Users/login', ['module' => 'Users', 'action' => 'doLogin'], 'do_login'];
$routes[] = ['GET', '/Users/registration', ['module' => 'Users', 'action' => 'registration'], 'registration'];
$routes[] = ['POST', '/Users/registration', ['module' => 'Users', 'action' => 'doRegistration'], 'do_registration'];
$routes[] = ['GET', '/Users/logout', ['module' => 'Users', 'action' => 'logout'], 'do_logout'];