<?php

namespace SetCMS\Module\Pages\PageModel;

use SetCMS\Module\Pages\Page;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;

class PageModelSave extends OrdinaryModel
{

    public ?int $id = null;

    /**
     * @setcms-required
     * @var string 
     */
    public string $slug = '';

    /**
     * @setcms-required
     * @var string 
     */
    public string $content = '';

    /**
     * @setcms-required
     * @var string 
     */
    public string $title = '';

    protected function bind(\SetCMS\Module\Ordinary\OrdinaryEntity $entity): Page
    {
        assert($entity instanceof Page);

        $entity->id = $this->id;
        $entity->slug = $this->slug;
        $entity->title = $this->title;
        $entity->content = $this->content;

        return $entity;
    }

}
