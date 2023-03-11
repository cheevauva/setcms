<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use Psr\Container\ContainerInterface;
use SetCMS\Contract\Servant;
use SetCMS\Scope;
use Throwable;
use SetCMS\Throwable\NotFound;
use SetCMS\Core\DAO\CoreReflectionMethodRetrieveByServerRequestDAO;
use Psr\Http\Message\ResponseInterface;
use SetCMS\Contract\Factory;
use SetCMS\Contract\Router;
use Psr\Http\Message\ServerRequestInterface;
use SetCMS\RequestAttribute;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Uri;
use League\CommonMark\CommonMarkConverter;
use SetCMS\Template\Template;

class ViewHtmlRender implements Servant
{

    use \SetCMS\QuickTrait;

    public object $mixedValue;
    public ?string $html = null;
    public ServerRequestInterface $request;

    public function serve(): void
    {
        $object = $this->mixedValue;
        
        if ($object instanceof Scope) {
            $templateName = (new \ReflectionObject($object))->getShortName();

            $template = Template::make($this->factory());
            $template->from($this->request);

            $this->html = $template->render($templateName, $object->toArray());
        }

        if ($object instanceof ResponseInterface) {
            $this->html = $object->getBody()->getContents();
        }
    }

}
