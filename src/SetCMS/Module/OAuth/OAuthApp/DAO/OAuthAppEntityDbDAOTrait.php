<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthApp\DAO;

use SetCMS\Module\OAuth\OAuthApp\Mapper\OAuthAppEntityDbMapper;
use SetCMS\Module\OAuth\OAuthApp\OAuthAppConstrants;

trait OAuthAppEntityDbDAOTrait
{

    use \SetCMS\DITrait;
    use \SetCMS\FactoryTrait;
    use \SetCMS\Database\MainConnectionTrait;

    protected function mapper(): OAuthAppEntityDbMapper
    {
        return OAuthAppEntityDbMapper::make($this->factory());
    }

    protected function table(): string
    {
        return OAuthAppConstrants::TABLE_NAME;
    }

}
