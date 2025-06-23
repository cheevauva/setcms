<?php

declare(strict_types=1);

$routes['GET /~/template/index AdminTemplateIndex'] = \SetCMS\Module\Template\Controller\TemplatePrivateIndexController::class;
$routes['GET /~/template/read/[g:id] AdminTemplateRead'] = \SetCMS\Module\Template\Controller\TemplatePrivateReadController::class;
$routes['GET /~/template/new/[g:id] AdminTemplateNew'] = \SetCMS\Module\Template\Controller\TemplatePrivateNewController::class;
$routes['GET /~/template/edit/[g:id] AdminTemplateEdit'] = \SetCMS\Module\Template\Controller\TemplatePrivateEditController::class;
$routes['POST /~/template/update/[g:id] AdminTemplateUpdate'] = \SetCMS\Module\Template\Controller\TemplatePrivateUpdateController::class;
$routes['POST /~/template/create/[g:id] AdminTemplateCreate'] = \SetCMS\Module\Template\Controller\TemplatePrivateCreateController::class;
