<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthCode\DAO;

use SetCMS\Module\OAuth\OAuthCode\Mapper\OAuthCodeEntityDbMapper;
use SetCMS\Module\OAuth\OAuthCode\OAuthCodeContants;

trait OAuthCodeEntityDbDAOTrait
{

    use \SetCMS\DITrait;
    use \SetCMS\Database\MainConnectionTrait;
    use \SetCMS\FactoryTrait;

    protected function mapper(): OAuthCodeEntityDbMapper
    {
        return OAuthCodeEntityDbMapper::make($this->factory());
    }

    protected function table(): string
    {
        return OAuthCodeContants::TABLE_NAME;
    }

}
