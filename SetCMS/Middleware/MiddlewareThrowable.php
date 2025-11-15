<?php

declare(strict_types=1);

namespace SetCMS\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use SetCMS\View\ViewForbidden;
use SetCMS\View\ViewNotFound;
use SetCMS\View\ViewNoContent;
use SetCMS\View\ViewInternalServerError;
use SetCMS\Router\Exception\RouterNotFoundException;
use SetCMS\Controller\Exception\ControllerEmptyResponseException;
use SetCMS\ACL\Exception\ACLNotAllowException;

class MiddlewareThrowable implements MiddlewareInterface, \UUA\ContainerConstructInterface
{

    use \UUA\Traits\ContainerTrait;
    use \UUA\Traits\BuildTrait;

    #[\Override]
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (ACLNotAllowException $ex) {
            $noContent = ViewForbidden::new($this->container);
            $noContent->message = $ex->getMessage();
            $noContent->serve();

            return $noContent->response;
        } catch (RouterNotFoundException $ex) {
            $notFound = ViewNotFound::new($this->container);
            $notFound->message = $ex->getMessage();
            $notFound->serve();

            return $notFound->response;
        } catch (ControllerEmptyResponseException $ex) {
            $noContent = ViewNoContent::new($this->container);
            $noContent->message = $ex->getMessage();
            $noContent->serve();

            return $noContent->response;
        } catch (\Throwable $ex) {
            $internalServerError = ViewInternalServerError::new($this->container);
            $internalServerError->message = $ex->getMessage() . '<pre>' . $ex->getTraceAsString() . '</pre>';
            $internalServerError->serve();

            return $internalServerError->response;
        }
    }
}
