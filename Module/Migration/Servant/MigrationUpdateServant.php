<?php

declare(strict_types=1);

namespace Module\Migration\Servant;

use Module\Migration\VO\MigrationCandidateVO;
use Module\Migration\Entity\MigrationEntity;
use Module\Migration\DAO\MigrationRunDAO;
use Module\Migration\DAO\MigrationSaveDAO;
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
        $run->sql = strtr($this->candidate->sql, [
            'ADMIN_USER_UUID' => ADMIN_USER_UUID,
        ]);
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
