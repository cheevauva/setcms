<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthClient\DAO;

class OAuthClientEntityRetrieveByEntityTypeDAO extends \SetCMS\Entity\DAO\EntityDbRetrieveByCriteriaDAO
{

    use OAuthClientEntityDbDAOTrait;

    public string $entityType;

    public function serve(): void
    {
        $this->criteria = [
            'deleted' => 0,
            'entity_type' => $this->entityType,
        ];

        parent::serve();
    }

}
