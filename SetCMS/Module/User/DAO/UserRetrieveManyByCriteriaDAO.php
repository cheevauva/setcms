<?php

declare(strict_types=1);

namespace SetCMS\Module\User\DAO;

class UserRetrieveManyByCriteriaDAO extends \SetCMS\Common\DAO\EntityRetrieveManyByCriteriaDAO
{

    public string $username;

    use UserCommonDAO;

    public function serve(): void
    {
        if (isset($this->username)) {
            $this->criteria['username'] = $this->username;
        }

        parent::serve();
    }
}
