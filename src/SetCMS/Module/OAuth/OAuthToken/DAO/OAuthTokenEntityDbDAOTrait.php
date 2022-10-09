<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthToken\DAO;

use SetCMS\Module\OAuth\OAuthToken\Mapper\OAuthTokenEntityDbMapper;
use SetCMS\Module\OAuth\OAuthToken\OAuthTokenConstants;

trait OAuthTokenEntityDbDAOTrait
{

    use \SetCMS\DITrait;
    use \SetCMS\Database\MainConnectionTrait;
    use \SetCMS\FactoryTrait;

    protected function mapper(): OAuthTokenEntityDbMapper
    {
        return OAuthTokenEntityDbMapper::make($this->factory());
    }

    protected function table(): string
    {
        return OAuthTokenConstants::TABLE_NAME;
    }

}
