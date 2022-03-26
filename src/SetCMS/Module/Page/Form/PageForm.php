<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Form;

use SetCMS\Core\Form;
use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\PageEntityRetrieveByIdDAO;

class PageForm extends Form
{

    public string $id;
    public string $slug;
    public string $content;
    public string $title;

    public function apply(object $object): void
    {
        parent::apply($object);

        if ($object instanceof PageEntity) {
            $object->id = $this->id;
            $object->slug = $this->slug;
            $object->content = $this->content;
            $object->title = $this->title;
        }

        if ($object instanceof PageEntityRetrieveByIdDAO) {
            $object->id = $this->id;
        }
    }

}
