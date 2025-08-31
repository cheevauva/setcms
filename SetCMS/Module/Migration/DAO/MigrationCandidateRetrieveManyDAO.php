<?php

declare(strict_types=1);

namespace SetCMS\Module\Migration\DAO;

use SetCMS\Module\Migration\VO\MigrationCandidateVO;

class MigrationCandidateRetrieveManyDAO extends \UUA\DAO
{

    use \UUA\Traits\ContainerTrait;

    /**
     * @var MigrationCandidateVO[]
     */
    public array $migrationCandidates;
    public string $dbName;
    public string $dbType;

    #[\Override]
    public function serve(): void
    {
        $basePath = sprintf('resources/migrations/%s/%s/', $this->dbType, $this->dbName);

        $files = glob($basePath . 'u.*.*.sql');

        if (!$files) {
            return;
        }

        ksort($files);

        $this->migrationCandidates = [];

        foreach ($files as $file) {
            $candidate = new MigrationCandidateVO();
            $candidate->version = basename($file);
            $candidate->file = $file;
            $candidate->sql = file_get_contents($file) ?: throw new \Exception(sprintf('Ошибка при получении содержимого файла %s', $file));
            $candidate->database = $this->dbName;

            $this->migrationCandidates[] = $candidate;
        }
    }
}
