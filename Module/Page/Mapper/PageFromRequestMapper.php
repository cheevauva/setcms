<?php

declare(strict_types=1);

namespace Module\Page\Mapper;

use Module\Page\Entity\PageEntity;

class PageFromRequestMapper extends \SetCMS\Mapper\MapperFromRequest
{

    public protected(set) PageEntity $page;

    #[\Override]
    public function serve(): void
    {
        $body = $this->validationBody();
        $body->array('entity')->notEmpty()->validate();

        $this->page = new PageEntity();
        $this->page->id = $body->uuid('entity.id')->val();
        $this->page->slug = $body->string('entity.slug')->notEmpty()->val();
        $this->page->title = $body->string('entity.title')->notEmpty()->val();
        $this->page->content = $body->string('entity.content')->notEmpty()->val();
    }
}
