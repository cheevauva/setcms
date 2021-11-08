<?php

namespace SetCMS\Module\Modules;

use SetCMS\Module\Module;
use SetCMS\Module\Modules\Contract\ModuleResourceInterface;
use Psr\Container\ContainerInterface;
use SetCMS\Module\Ordinary\OrdinaryDAO;

class ModuleDAO extends OrdinaryDAO
{

    private array $modules = [];
    private array $resources = [];
    private array $entities = [];
    private array $meta = [];

    public function __construct(ContainerInterface $container)
    {
        $this->meta = $container->get('modules');
    }

    public function findByResource(string $resource): ?Module
    {
        return $this->resources[$resource] ?? null;
    }

    public function findByEntity($entity): ?Module
    {
        return $this->entities[get_class($entity)] ?? null;
    }

    public function find(string $moduleName): Module
    {
        if (!empty($this->modules[$moduleName])) {
            return $this->modules[$moduleName];
        }

        if (empty($this->meta[$moduleName])) {
            throw ModuleException::notFoundModule($moduleName);
        }

        $moduleClassName = $this->meta[$moduleName];

        if (!class_exists($moduleClassName, true)) {
            throw ModuleException::notFoundModule($moduleName);
        }

        $module = new $moduleClassName($moduleName);

        if ($module instanceof ModuleResourceInterface) {
            $this->resources[$module->getResource()] = $module;
            $this->entities[$module->getEntityClassName()] = $module;
        }

        return $this->modules[$moduleName] = $module;
    }

    protected function entity2record(\SetCMS\Module\Ordinary\OrdinaryEntity $entity): array
    {
        
    }

    protected function getException(): \Exception
    {
        
    }

    protected function getTableName(): string
    {
        
    }

    protected function record2entity(array $record): \SetCMS\Module\Ordinary\OrdinaryEntity
    {
        
    }

}
