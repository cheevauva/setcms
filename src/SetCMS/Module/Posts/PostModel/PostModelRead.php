<?php

namespace SetCMS\Module\Posts\PostModel;

use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;

class PostModelRead extends OrdinaryModel
{

    /**
     * @setcms-type-string
     * @setcms-required
     * @var string
     */
    public string $slug = '';

}
