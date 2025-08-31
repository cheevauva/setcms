<?php

declare(strict_types=1);

namespace SetCMS\Module\Migration\Servant;

use UUA\Servant;
use SetCMS\Database\DatabaseFactory;
use SetCMS\Database\Servant\DatabaseTransactionServant;
use SetCMS\Module\Migration\DAO\MigrationRetrieveManyByCriteriaDAO;
use SetCMS\Module\Migration\DAO\MigrationCandidateRetrieveManyDAO;
use SetCMS\Module\Migration\VO\MigrationCandidateVO;
use SetCMS\Module\Migration\Servant\MigrationUpdateServant;
use SetCMS\Module\Migration\Entity\MigrationEntity;

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

        $retrieveExecuted = MigrationRetrieveManyByCriteriaDAO::new($this->container);
        $retrieveExecuted->db = $db;
        $retrieveExecuted->serve();

        $retrieveCandidates = MigrationCandidateRetrieveManyDAO::new($this->container);
        $retrieveCandidates->dbName = $this->dbName;
        $retrieveCandidates->dbType = $db->connectionDriverName();
        $retrieveCandidates->serve();

        $executedMigrations = $this->executedOld = $retrieveExecuted->migrations;
        $candidates = $retrieveCandidates->migrationCandidates;

        $this->executedNew = [];
        $this->failded = [];

        foreach ($candidates as $candidate) {
            $candidate = MigrationCandidateVO::as($candidate);

            if (isset($executedMigrations[$candidate->version])) {
                continue;
            }

            $updater = MigrationUpdateServant::new($this->container);
            $updater->db = $db;
            $updater->candidate = $candidate;

            try {
                $transaction = DatabaseTransactionServant::new($this->container);
                $transaction->db = $db;
                $transaction->servant = $updater;
                $transaction->serve();

                $this->executedNew[] = $candidate;
            } catch (\Throwable $ex) {
                $candidate->error = $ex;

                $this->failded[] = $candidate;
            }
        }
    }
}
