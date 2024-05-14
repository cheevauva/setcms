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
    public array $vars = [];
    public ?string $html = null;
    public ?string $templateName = null;
    public ServerRequestInterface $request;

    public function serve(): void
    {
        $value = $this->mixedValue;

        if ($value instanceof Scope) {
            $templateName = $this->templateName ?? $this->templateNameByScope($value);

            $template = TemplateFactory::make($this->container)->create($this->templateEngine());

            if (!$template->has($templateName)) {
                return;
            }

            $template->from($this->request);
            $template->assign('scope', $value);

            foreach ($this->vars as $v => $vv) {
                $template->assign($v, $vv);
            }

            $this->html = $template->render($templateName, $value->toArray());
        }

        if ($value instanceof ResponseInterface) {
            $this->html = $value->getBody()->getContents();
        }
    }

    private function templateNameByScope(Scope $scope): string
    {
        $templateName = (new \ReflectionObject($scope))->getShortName();

        return $templateName;
    }

    private function templateEngine(): TemplateEnum
    {
        return TemplateEnum::from($this->env()['TEMPLATE_ENGINE']);
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
