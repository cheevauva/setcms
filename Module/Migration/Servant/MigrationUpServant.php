<?php

declare(strict_types=1);

namespace Module\Migration\Servant;

use UUA\Servant;
use SetCMS\Database\DatabaseFactory;
use SetCMS\Database\Servant\DatabaseTransactionServant;
use Module\Migration\DAO\MigrationRetrieveManyByCriteriaDAO;
use Module\Migration\DAO\MigrationCandidateRetrieveManyDAO;
use Module\Migration\VO\MigrationCandidateVO;
use Module\Migration\Servant\MigrationUpdateServant;
use Module\Migration\Entity\MigrationEntity;
use Module\Migration\DAO\MigrationCheckStorageDAO;

class MigrationUpServant extends Servant
{

    public string $dbName;

    /**
     * @var array<int, MigrationCandidateVO>
     */
    public protected(set) array $executedNew;

    /**
     * @var array<string, MigrationEntity>
     */
    public protected(set) array $executedOld;

    /**
     * @var array<int, MigrationCandidateVO>
     */
    public protected(set) array $failded;

    #[\Override]
    public function serve(): void
    {
        $db = DatabaseFactory::singleton($this->container)->make($this->dbName);

        $check = MigrationCheckStorageDAO::new($this->container);
        $check->db = $db;
        $check->serve();

        $executedMigrations = [];

        if ($check->isOk) {
            $retrieveExecuted = MigrationRetrieveManyByCriteriaDAO::new($this->container);
            $retrieveExecuted->db = $db;
            $retrieveExecuted->serve();

            $executedMigrations = $this->migrationsKeyValue($retrieveExecuted->migrations);
        }

        $this->executedOld = $executedMigrations;

        $retrieveCandidates = MigrationCandidateRetrieveManyDAO::new($this->container);
        $retrieveCandidates->dbName = $this->dbName;
        $retrieveCandidates->dbType = $db->connectionDriverName();
        $retrieveCandidates->serve();

        $candidates = $retrieveCandidates->migrationCandidates;

        $this->executedNew = [];
        $this->failded = [];

        foreach ($candidates as $candidate) {
            $candidate = MigrationCandidateVO::as($candidate);

            if (isset($executedMigrations[$candidate->version])) {
                continue;
            }
            
            try {
                $updater = MigrationUpdateServant::new($this->container);
                $updater->db = $db;
                $updater->candidate = $candidate;

                $transaction = DatabaseTransactionServant::new($this->container);
                $transaction->db = $db;
                $transaction->servant = $updater;
                $transaction->serve();

                $this->executedNew[] = $candidate;
            } catch (\Throwable $ex) {
                var_dump($ex->getMessage());
                $candidate->error = $ex;

                $this->failded[] = $candidate;
            }
        }
    }

    /**
     * 
     * @param array<MigrationEntity> $migrations
     * @return  array<string, MigrationEntity>
     */
    protected function migrationsKeyValue(array $migrations): array
    {
        $newMigrations = [];

        foreach ($migrations as $migration) {
            $newMigrations[MigrationEntity::as($migration)->version] = $migration;
        }

        return $newMigrations;
    }
}
