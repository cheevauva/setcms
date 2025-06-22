<?php

declare(strict_types=1);

$routes['GET /captcha/generate CaptchaGenerate'] = \SetCMS\Module\Captcha\Controller\CaptchaPublicGenerateController::class;
$routes['GET /captcha/solve CaptchaSolve'] = \SetCMS\Module\Captcha\Controller\CaptchaPublicSolveController::class;
