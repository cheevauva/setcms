<?php

namespace SetCMS\Module;

use SetCMS\Resource\ResourceModuleInterface;
use SetCMS\Module;

class Users extends Module implements ResourceModuleInterface
{

    public function getPrefix(): string
    {
        return __CLASS__ . '\User';
    }

    public function getResource(): string
    {
        return 'user';
    }

}
