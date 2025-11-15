<?php

declare(strict_types=1);

$routes['GET /~/template/index AdminTemplateIndex'] = \Module\Template\Controller\TemplatePrivateIndexController::class;
$routes['GET /~/template/read/[g:id] AdminTemplateRead'] = \Module\Template\Controller\TemplatePrivateReadController::class;
$routes['GET /~/template/new/[g:id] AdminTemplateNew'] = \Module\Template\Controller\TemplatePrivateNewController::class;
$routes['GET /~/template/edit/[g:id] AdminTemplateEdit'] = \Module\Template\Controller\TemplatePrivateEditController::class;
$routes['POST /~/template/update/[g:id] AdminTemplateUpdate'] = \Module\Template\Controller\TemplatePrivateUpdateController::class;
$routes['POST /~/template/create/[g:id] AdminTemplateCreate'] = \Module\Template\Controller\TemplatePrivateCreateController::class;
