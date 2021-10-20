<?php

namespace SetCMS\Module\Pages\PageModel;

use SetCMS\Module\Pages\Page;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;

class PageModelSave extends OrdinaryModel
{

    public string $id = '';

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

    protected function validate(): void
    {
        parent::validate();
        
        if (!preg_match('/^[a-z0-9_]+$/', $this->slug)) {
            $this->addMessageAsValidation('Только латинские буквы, цифры и подчеркивание', 'slug');
        }
    }

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
