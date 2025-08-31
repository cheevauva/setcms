<?php

declare(strict_types=1);

namespace SetCMS\Module\Migration\Servant;

use SetCMS\Module\Migration\DAO\MigrationRetrieveManyByCriteriaDAO;
use SetCMS\Database\DatabaseFactory;

class MigrationDownServant extends \UUA\Servant
{

    public string $dbName;

    #[\Override]
    public function serve(): void
    {
        $db = DatabaseFactory::singleton($this->container)->make($this->dbName);

        $retrieveExecuted = MigrationRetrieveManyByCriteriaDAO::new($this->container);
        $retrieveExecuted->db = $db;
        $retrieveExecuted->serve();
    }
}
