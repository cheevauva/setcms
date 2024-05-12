<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use SetCMS\Contract\Servant;
use SetCMS\Contract\Applicable;
use SetCMS\Scope;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SetCMS\View\Hook\ViewRenderHook;
use SetCMS\Template\TemplateFactory;
use SetCMS\Template\TemplateEnum;

class ViewHtmlRender implements Servant, Applicable
{

    use \SetCMS\QuickTrait;
    use \SetCMS\EnvTrait;

    public object $mixedValue;
    public ?string $html = null;
    public ServerRequestInterface $request;

    public function serve(): void
    {
        $object = $this->mixedValue;

        if ($object instanceof Scope) {
            $templateName = (new \ReflectionObject($object))->getShortName();

            $template = TemplateFactory::make($this->container)->create(TemplateEnum::tryFrom($this->env()['TEMPLATE_ENGINE']));

            if (!$template->has($templateName)) {
                return;
            }

            $template->from($this->request);

            $vars = $object->toArray();
            $vars['scope'] = $object;
            
            $this->html = $template->render($templateName, $vars);
        }

        if ($object instanceof ResponseInterface) {
            $this->html = $object->getBody()->getContents();
        }
    }

    public function from(object $object): void
    {
        if ($object instanceof ViewRenderHook) {
            $this->mixedValue = $object->data;
            $this->request = $object->request;
        }
    }

    public function to(object $object): void
    {
        if ($object instanceof ViewRenderHook) {
            $object->content = $this->html;
            $object->contentType = 'text/html';
        }
    }

}
