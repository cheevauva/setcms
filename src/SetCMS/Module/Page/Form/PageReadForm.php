<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Form;

use SetCMS\Module\Page\PageEntity;
use SetCMS\Module\Page\DAO\PageEntityDbRetrieveByIdDAO;

class PageReadForm extends \SetCMS\Scope
{

    public string $id;
    private ?PageEntity $entity = null;

    public function apply(object $object): void
    {
        parent::apply($object);

        if ($object instanceof PageEntityDbRetrieveByIdDAO) {
            $this->entity = $object->entity;
        }
    }

}
