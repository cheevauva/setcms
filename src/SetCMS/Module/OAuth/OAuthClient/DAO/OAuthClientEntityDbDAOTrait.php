<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthClient\DAO;

use SetCMS\Module\OAuth\OAuthClient\Mapper\OAuthClientEntityDbMapper;
use SetCMS\Module\OAuth\OAuthClient\OAuthClientContstants;

trait OAuthClientEntityDbDAOTrait
{

    use \SetCMS\DITrait;
    use \SetCMS\Database\MainConnectionTrait;
    use \SetCMS\FactoryTrait;

    protected function mapper(): OAuthClientEntityDbMapper
    {
        return OAuthClientEntityDbMapper::make($this->factory());
    }

    protected function table(): string
    {
        return OAuthClientContstants::TABLE_NAME;
    }

}
