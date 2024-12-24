<?php

declare(strict_types=1);

namespace SetCMS\Module\Mirror\DAO;

use SetCMS\Application\Contract\ContractServant;
use SetCMS\Module\Mirror\Entity\MirrorControllerEntity;

class MirrorRetrieveManyControllersDAO implements ContractServant
{

    use \SetCMS\Traits\FactoryTrait;

    public array $controllers;
    public bool $isPublic;
    public bool $isPrivate;

    #[\Override]
    public function serve(): void
    {
        $basePath = '../src';
        $files = glob(sprintf('%s/SetCMS/Module/*/Controller/*Controller.php', $basePath));

        $this->controllers = [];

        foreach ($files as $filename) {
            $controller = new MirrorControllerEntity;
            $controller->isPublic = str_contains($filename, 'PublicController.php');
            $controller->isPrivate = str_contains($filename, 'PrivateController.php');
            $controller->filename = $filename;
            $controller->className = strtr($filename, [
                $basePath . '/' => '',
                '/' => '\\',
                '.php' => '',
            ]);
            $controller->module = explode('\\', $controller->className)[2];

            $this->controllers[] = $controller;
        }

        foreach ($this->controllers as $index => $controller) {
            $controller = MirrorControllerEntity::as($controller);

            if (isset($this->isPublic) && $this->isPublic && !$controller->isPublic) {
                unset($this->controllers[$index]);
            }

            if (isset($this->isPrivate) && $this->isPrivate && !$controller->isPrivate) {
                unset($this->controllers[$index]);
            }
        }
    }
}
