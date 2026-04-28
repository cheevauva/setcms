<?php

declare(strict_types=1);

namespace Module\Template\Mapper;

use Module\Template\Entity\TemplateEntity;

class TemplateFromRowMapper extends \UUA\Mapper
{

    use \SetCMS\Mapper\MapperEntityFromRowTrait;

    public protected(set) TemplateEntity $template;

    #[\Override]
    protected function notFoundKeyInRowException(string $key): \Throwable
    {
        throw new \Exception($key);
    }

    #[\Override]
    public function serve(): void
    {
        $this->template = new TemplateEntity();
        $this->template->template = $this->string('template');
        $this->template->title = $this->string('title');
        $this->template->slug = $this->string('slug');
        $this->mappingDefault($this->template);
    }
}
