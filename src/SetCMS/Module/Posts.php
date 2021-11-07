<?php

namespace SetCMS\Module;

use SetCMS\Resource\ResourceModuleInterface;
use SetCMS\Module;

class Posts extends Module implements ResourceModuleInterface
{

    public function getPrefix(): string
    {
        return __CLASS__ . '\Post';
    }

    public function getResource(): string
    {
        return 'post';
    }

}
