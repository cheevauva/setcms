<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthApp\Servant;

use SetCMS\Module\OAuth\OAuthApp\DAO\OAuthAppEntityHasByIdDAO;
use SetCMS\Module\OAuth\OAuthApp\DAO\OAuthAppEntitySaveDAO;

class OAuthAppEntityCreateServant extends \SetCMS\Entity\Servant\EntityCreateServant
{

    use \SetCMS\DITrait;

    protected function hasEntityById(): OAuthAppEntityHasByIdDAO
    {
        return OAuthAppEntityHasByIdDAO::make($this->factory());
    }

    protected function saveEntity(): OAuthAppEntitySaveDAO
    {
        return OAuthAppEntitySaveDAO::make($this->factory());
    }

}
