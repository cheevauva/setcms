<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Scope;

use SetCMS\Module\Page\PageEntity;
use SetCMS\UUID;

class PagePrivatePageScope extends PagePrivateScope
{

    public UUID $id;
    public string $slug;
    public string $title;
    public string $content;

    public function satisfy(): \Iterator
    {
        parent::satisfy();

        if (0) {
            yield ['', ''];
        }
    }

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PageEntity) {
            $object->id = $this->id;
            $object->slug = $this->slug;
            $object->title = $this->title;
            $object->content = $this->content;
        }
    }

}
