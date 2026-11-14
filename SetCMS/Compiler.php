<?php

declare(strict_types=1);

namespace SetCMS;

class Compiler
{

    use \UUA\Traits\BuildTrait;
    use \UUA\Traits\ContainerTrait;

    /**
     * @param string $name
     * @return array<mixed, mixed>
     */
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
