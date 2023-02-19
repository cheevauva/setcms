<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthApp\Scope;

use SetCMS\Module\OAuth\OAuthApp\OAuthAppEntity;

trait OAuthAppPrivateEntityScopeTrait
{

    public string $name;

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof OAuthAppEntity) {
            $object->name = $this->name;
        }
    }

}
