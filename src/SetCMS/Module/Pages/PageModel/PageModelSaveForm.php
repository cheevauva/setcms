<?php

namespace SetCMS\Module\Pages\PageModel;

use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;
use SetCMS\Module\Pages\Page;
use SetCMS\Module\Ordinary\OrdinaryEntity;

class PageModelSaveForm extends OrdinaryModel
{

    public string $slug = '';
    public string $title = 'Название страницы';
    public string $content = '';

    public function bind(OrdinaryEntity $entity): Page
    {
        assert($entity instanceof Page);

        $entity->slug = $this->slug;
        $entity->title = $this->title;

        return $entity;
    }

}
