<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthClient\Servant;

use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntityHasByIdDAO;
use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntitySaveDAO;

class OAuthClientEntityUpdateServant extends \SetCMS\Entity\Servant\EntityUpdateServant
{

    use \SetCMS\DITrait;

    protected function hasEntityById(): OAuthClientEntityHasByIdDAO
    {
        return OAuthClientEntityHasByIdDAO::make($this->factory());
    }

    protected function saveEntity(): OAuthClientEntitySaveDAO
    {
        return OAuthClientEntitySaveDAO::make($this->factory());
    }

}