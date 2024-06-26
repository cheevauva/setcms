<?php

declare(strict_types=1);

namespace SetCMS\Template;

use SetCMS\Contract\ContractTemplateEngineInterface;

class TemplateFactory
{
    use \SetCMS\QuickTrait;
    
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
