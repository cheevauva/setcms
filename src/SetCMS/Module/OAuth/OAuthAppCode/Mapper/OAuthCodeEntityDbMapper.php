<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthAppCode\Mapper;

use SetCMS\Module\OAuth\OAuthAppCode\OAuthAppCodeEntity;
use SetCMS\UUID;

class OAuthAppCodeEntityDbMapper extends \SetCMS\Entity\Mapper\EntityDbMapper
{

    use \SetCMS\FactoryTrait;

    protected function entity(): OAuthAppCodeEntity
    {
        return parent::entity();
    }

    protected function entity2row(): void
    {
        parent::entity2row();

        $this->row['code'] = $this->entity()->code;
        $this->row['app_id'] = (string) $this->entity()->appId;
        $this->row['user_id'] = (string) $this->entity()->userId;
    }

    protected function entity4row(): void
    {
        parent::entity4row();

        $this->entity()->code = $this->row['code'];
        $this->entity()->userId = new UUID($this->row['user_id']);
        $this->entity()->appId = new UUID($this->row['app_id']);
    }

}
