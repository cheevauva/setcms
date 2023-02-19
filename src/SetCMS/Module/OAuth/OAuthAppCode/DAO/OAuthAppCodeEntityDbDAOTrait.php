<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthAppCode\DAO;

use SetCMS\Module\OAuth\OAuthAppCode\Mapper\OAuthAppCodeEntityDbMapper;
use SetCMS\Module\OAuth\OAuthAppCode\OAuthAppCodeContants;

trait OAuthAppCodeEntityDbDAOTrait
{

    use \SetCMS\DITrait;
    use \SetCMS\Database\MainConnectionTrait;
    use \SetCMS\FactoryTrait;

    protected function mapper(): OAuthAppCodeEntityDbMapper
    {
        return OAuthAppCodeEntityDbMapper::make($this->factory());
    }

    protected function table(): string
    {
        return OAuthAppCodeContants::TABLE_NAME;
    }

}
