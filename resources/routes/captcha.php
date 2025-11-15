<?php

declare(strict_types=1);

$routes['GET /captcha/generate CaptchaGenerate'] = \Module\Captcha\Controller\CaptchaPublicGenerateController::class;
$routes['GET /captcha/solve CaptchaSolve'] = \Module\Captcha\Controller\CaptchaPublicSolveController::class;
