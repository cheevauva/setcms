<?php

declare(strict_types=1);

namespace SetCMS\Application\Template;

use SetCMS\Contract\ContractTemplateEngineInterface;

class TemplateFactory
{
    use \SetCMS\Traits\QuickTrait;
    
    public function create(?TemplateEnum $template = null): ContractTemplateEngineInterface
    {
        if (is_null($template)) {
            $template = TemplateEnum::Twig;
        }
        
        switch ($template) {
            default:
                return TemplateTwig::make($this->factory());
        }
    }

}
