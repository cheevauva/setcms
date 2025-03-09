<?php

declare(strict_types=1);

namespace SetCMS\Module\Dynamic\DAO;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response;
use SetCMS\Controller;

class DynamicMethodRetrieveByServerRequestDAO extends \UUA\DAO
{

    use \UUA\Traits\ContainerTrait;

    public ServerRequestInterface $request;
    public ?ResponseInterface $response = null;
    public Controller $controller;

    public function serve(): void
    {
        $request = $this->request;

        if (empty($this->response)) {
            $this->response = new Response;
        }

        $className = $request->getAttribute('routeTarget');
        

        $this->controller = Controller::as($className::new($this->container));;
    }
}
