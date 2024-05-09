<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Scope;

use SetCMS\Module\Page\PageEntity;
use SetCMS\UUID;
use SetCMS\Attribute;

class PagePrivatePageScope extends PagePrivateScope
{

    public UUID $id;

    #[Attribute\NotBlank]
    public string $slug;

    #[Attribute\NotBlank]
    public string $title;

    #[Attribute\NotBlank]
    public string $content;

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
