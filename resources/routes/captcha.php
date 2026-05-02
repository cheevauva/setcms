<?php

declare(strict_types=1);

$routes['POST /captcha/generate CaptchaGenerate'] = \Module\Captcha\Controller\CaptchaPublicGenerateController::class;
$routes['POST /captcha/solve CaptchaSolve'] = \Module\Captcha\Controller\CaptchaPublicSolveController::class;
