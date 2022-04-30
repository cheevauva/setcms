<?php

declare(strict_types=1);

namespace SetCMS\Module\Page\Form;

use SetCMS\Module\Page\Servant\PageEntityDeleteServant;

class PageDeleteForm extends \SetCMS\Core\Form
{

    public string $id;

    public function apply(object $object): void
    {
        parent::apply($object);

        if ($object instanceof PageEntityDeleteServant) {
            $object->id = $this->id;
            $this->entity = $object->entity;
        }
    }

}
