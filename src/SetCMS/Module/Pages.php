<?php

namespace SetCMS\Module;

use SetCMS\Resource\ResourceModuleInterface;
use SetCMS\Module;

class Pages extends Module implements ResourceModuleInterface
{

    public function getPrefix(): string
    {
        return __CLASS__ . '\Page';
    }

    public function getResource(): string
    {
        return 'page';
    }

}
