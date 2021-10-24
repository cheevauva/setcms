<?php

namespace SetCMS\Module\Pages;

use SetCMS\Module\Ordinary\OrdinaryEntity;

class Page extends OrdinaryEntity
{

    public string $module = 'Pages';
    public string $resource = 'page';
    public $slug;
    public $title;
    public $content;

}
