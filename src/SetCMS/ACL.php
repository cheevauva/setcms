<?php

namespace SetCMS;

use Laminas\Permissions\Acl\Acl as LaminasAcl;
use Psr\Container\ContainerInterface;

class ACL extends LaminasAcl
{

    use FactoryTrait;

    public function __construct(ContainerInterface $container)
    {
        $this->setup($container->get('acl'));
    }

    private function setup(array $setup)
    {
        foreach ($setup['roles'] as $role => $parents) {
            $this->addRole($role, $parents);
        }

        foreach ($setup['rules'] as $role => $resources) {
            if (!$this->hasRole($role)) {
                $this->addRole($role);
            }

            foreach ($resources as $resource => $rules) {
                if (!$this->hasResource($resource)) {
                    $this->addResource($resource);
                }

                foreach ($rules as $rule => $access) {
                    if ($access) {
                        $this->allow($role, $resource, $rule);
                    } else {
                        $this->deny($role, $resource, $rule);
                    }
                }
            }
        }
    }

}
