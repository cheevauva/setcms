<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Scope;

use SetCMS\Module\Page\PageEntity;

class PagePrivateSaveScope extends \SetCMS\Entity\Scope\EntitySaveScope
{

    public string $slug;
    public string $content;
    public string $title;

    public function __construct()
    {
        $this->entity = new PageEntity;
    }

    public function satisfy(): \Iterator
    {
        if (!empty($this->slug) && !preg_match('/^[a-zA-Z0-9_]+$/', $this->slug)) {
            yield ['Только латинские буквы, цифры и подчеркивание', 'slug'];
        }
    }

    public function apply(object $object): void
    {
        if ($object instanceof PageEntity) {
            $object->slug = $this->slug;
            $object->title = $this->title;
            $object->content = $this->content;
        }
    }

    public function toArray(): array
    {
        return [
            'page' => $this->entity,
        ];
    }

}
