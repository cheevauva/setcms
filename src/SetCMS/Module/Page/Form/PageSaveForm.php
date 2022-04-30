<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Form;

use SetCMS\Core\Form;
use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\Servant\PageEntitySaveServant;
use SetCMS\Module\Page\DAO\PageEntityDbRetrieveByIdDAO;

class PageSaveForm extends Form
{

    public string $slug;
    public string $content;
    public string $title;
    private PageEntity $entity;

    public function apply(object $object): void
    {
        parent::apply($object);

        if ($object instanceof PageEntity) {
            $object->slug = $this->slug;
            $object->content = $this->content;
            $object->title = $this->title;
        }

        if ($object instanceof PageEntitySaveServant) {
            $object->apply = $this;
            $this->entity = $object->entity;
        }
    }

}
