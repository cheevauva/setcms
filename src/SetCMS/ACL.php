<?php

namespace SetCMS;

use Laminas\Permissions\Acl\Acl as LaminasAcl;
use Laminas\Permissions\Acl\Role\GenericRole as Role;
use Laminas\Permissions\Acl\Resource\GenericResource as Resource;

class ACL extends LaminasAcl
{

    public function setup(array $setup)
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
