<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthAppToken\DAO;

use SetCMS\Module\OAuth\OAuthAppToken\Mapper\OAuthAppTokenEntityDbMapper;
use SetCMS\Module\OAuth\OAuthAppToken\OAuthAppTokenConstants;

trait OAuthAppTokenEntityDbDAOTrait
{

    use \SetCMS\DITrait;
    use \SetCMS\Database\MainConnectionTrait;
    use \SetCMS\FactoryTrait;

    protected function mapper(): OAuthAppTokenEntityDbMapper
    {
        return OAuthAppTokenEntityDbMapper::make($this->factory());
    }

    protected function table(): string
    {
        return OAuthAppTokenConstants::TABLE_NAME;
    }

}
