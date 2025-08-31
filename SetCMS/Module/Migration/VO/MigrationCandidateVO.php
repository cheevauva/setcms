<?php

declare(strict_types=1);

namespace SetCMS\Module\Migration\VO;

class MigrationCandidateVO extends \UUA\VO
{

    public string $version;
    public string $database;
    public string $sql;
    public string $file;
    public ?\Throwable $error = null;
}
