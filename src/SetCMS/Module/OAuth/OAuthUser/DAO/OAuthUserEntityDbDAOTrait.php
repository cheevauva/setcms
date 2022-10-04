<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthUser\DAO;

use SetCMS\Module\OAuth\OAuthUser\Mapper\OAuthUserEntityDbMapper;
use SetCMS\Module\OAuth\OAuthUser\OAuthUserContstants;

trait OAuthUserEntityDbDAOTrait
{

    use \SetCMS\DITrait;
    use \SetCMS\Database\MainConnectionTrait;
    use \SetCMS\FactoryTrait;

    protected function mapper(): OAuthUserEntityDbMapper
    {
        return OAuthUserEntityDbMapper::make($this->factory());
    }

    protected function table(): string
    {
        return OAuthUserContstants::TABLE_NAME;
    }

}
