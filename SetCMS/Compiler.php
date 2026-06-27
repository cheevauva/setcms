<?php

declare(strict_types=1);

namespace SetCMS;

class Compiler
{

    use \UUA\Traits\BuildTrait;
    use \UUA\Traits\ContainerTrait;

    public function getAsArray(string $name): array
    {
        $rootPath = $this->container->get('rootPath');
        
        list($sourcePath, $cachePath) = $this->container->get('compiler')[$name];

        if (file_exists($rootPath . $cachePath)) {
            $items = require $rootPath . $cachePath;
        } else {
            $items = require $rootPath . $sourcePath;
        }
        
        return $items;
    }
}
