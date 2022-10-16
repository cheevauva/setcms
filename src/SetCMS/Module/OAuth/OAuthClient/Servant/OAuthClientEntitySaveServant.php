<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthClient\Servant;

use SetCMS\Module\OAuth\OAuthClient\OAuthClientEntity;
use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntityRetrieveByIdDAO;
use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntitySaveDAO;

class OAuthClientEntitySaveServant extends \SetCMS\Entity\Servant\EntitySaveServant
{

    use \SetCMS\DITrait;

    protected function entity(): OAuthClientEntity
    {
        return new OAuthClientEntity;
    }

    protected function retrieveEntityById(): OAuthClientEntityRetrieveByIdDAO
    {
        return OAuthClientEntityRetrieveByIdDAO::make($this->factory());
    }

    protected function saveEntity(): \SetCMS\Entity\DAO\EntityDbSaveDAO
    {
        return OAuthClientEntitySaveDAO::make($this->factory());
    }

}
