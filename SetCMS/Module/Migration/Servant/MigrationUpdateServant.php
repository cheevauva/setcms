<?php

declare(strict_types=1);

namespace SetCMS\Module\Migration\Servant;

use SetCMS\Module\Migration\VO\MigrationCandidateVO;
use SetCMS\Module\Migration\Entity\MigrationEntity;
use SetCMS\Module\Migration\DAO\MigrationRunDAO;
use SetCMS\Module\Migration\DAO\MigrationSaveDAO;
use SetCMS\Database\Database;

class MigrationUpdateServant extends \UUA\Servant
{

    public MigrationCandidateVO $candidate;
    public Database $db;
    public MigrationEntity $migration;

    #[\Override]
    public function serve(): void
    {
        $start = microtime(true);

        $run = MigrationRunDAO::new($this->container);
        $run->db = $this->db;
        $run->sql = $this->candidate->sql;
        $run->serve();

        $migration = $this->migration = new MigrationEntity();
        $migration->version = $this->candidate->version;
        $migration->executedAt = new \DateTimeImmutable;
        $migration->executionTime = intval(microtime(true) - $start);

        $save = MigrationSaveDAO::new($this->container);
        $save->migration = $migration;
        $save->db = $this->db;
        $save->serve();
    }
}
