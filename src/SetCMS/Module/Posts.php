<?php

namespace SetCMS\Module;

class Posts extends \SetCMS\Module
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
