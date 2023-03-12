<?php

declare(strict_types=1);

namespace SetCMS\Module\Block;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class BlockPublicController
{

    use \SetCMS\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function blocksBySection(ServerRequestInterface $request)
    {
        
    }

}
