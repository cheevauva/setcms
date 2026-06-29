<?php

declare(strict_types=1);

namespace Module\Template\Mapper;

use Module\Template\Entity\TemplateEntity;
use Module\Template\Exception\TemplateMapperNotFoundKeyInRowException;

class TemplateFromRowMapper extends \SetCMS\Entity\Mapper\EntityFromRowMapper
{

    public protected(set) TemplateEntity $template;

    #[\Override]
    protected function notFoundKeyInRowException(string $key): TemplateMapperNotFoundKeyInRowException
    {
        throw new TemplateMapperNotFoundKeyInRowException($key);
    }

    #[\Override]
    public function serve(): void
    {
        $this->template = new TemplateEntity();
        $this->template->template = $this->string('template');
        $this->template->title = $this->string('title');
        $this->template->slug = $this->string('slug');
        $this->id($this->template);
    }
}
