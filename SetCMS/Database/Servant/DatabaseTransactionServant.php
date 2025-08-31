<?php

declare(strict_types=1);

namespace SetCMS\Database\Servant;

use SetCMS\Database\Database;
use SetCMS\Database\DatabaseFactory;
use Throwable;
use UUA\Unit;

class DatabaseTransactionServant extends \UUA\Servant
{

    public Database $db;
    public Unit $servant;

    #[\Override]
    public function serve(): void
    {
        $this->db ??= DatabaseFactory::new($this->container)->make('main');
        $this->db->beginTransaction();

        try {
            $this->servant->serve();
            $this->db->commit();
        } catch (Throwable $ex) {
            $this->db->rollBack();

            throw $ex;
        }
    }
}
