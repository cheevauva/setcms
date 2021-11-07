<?php

namespace SetCMS\Module;

use SetCMS\Resource\ResourceModuleInterface;
use SetCMS\Module;

class Blocks extends Module implements ResourceModuleInterface
{

    public function getPrefix(): string
    {
        return __CLASS__ . '\Block';
    }

    public function getResource(): string
    {
        return 'block';
    }

}
