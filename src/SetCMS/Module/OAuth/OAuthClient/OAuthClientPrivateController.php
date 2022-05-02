<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthClient;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\FactoryInterface;
use SetCMS\Controller\Servant\ExecuteDynamicControllerServant;

class OAuthClientPrivateController
{

    use \SetCMS\Controller\ControllerTrait;
    use \SetCMS\Router\RouterTrait;

    public function resolve(ServerRequestInterface $request, ResponseInterface $response, FactoryInterface $factory)
    {
        if ($request->getAttribute('action') === __FUNCTION__) {
            throw new \SetCMS\Exception('not found');
        }
        
        $executer = ExecuteDynamicControllerServant::factory($factory);
        $executer->className = __CLASS__;
        $executer->action = $request->getAttribute('action');
        $executer->apply($request);
        $executer->apply($response);
        $executer->serve();

        return $executer->mixedValue;
    }

    public function index()
    {
        die('index');
    }

    public function save()
    {
        die('save');
    }

}
