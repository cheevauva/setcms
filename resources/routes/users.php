<?php

$routes[] = ['GET', '/Users/login', ['module' => 'Users', 'action' => 'login'], 'login'];
$routes[] = ['POST', '/Users/login', ['module' => 'Users', 'action' => 'doLogin'], 'do_login'];
$routes[] = ['GET', '/Users/registation', ['module' => 'Users', 'action' => 'registation'], 'registation'];
$routes[] = ['POST', '/Users/registation', ['module' => 'Users', 'action' => 'doRegistation'], 'do_registation'];
