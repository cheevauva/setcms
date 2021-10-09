<?php

namespace SetCMS\Module;

class Migrations extends \SetCMS\Module
{

    public function getPrefix(): string
    {
        return __CLASS__ . '\Migration';
    }

}
