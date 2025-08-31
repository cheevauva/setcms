<?php

declare(strict_types=1);

namespace SetCMS\Module\Migration\Entity;

use SetCMS\Module\Migration\VO\MigrationCandidateVO;

class MigrationEntity extends \SetCMS\Common\Entity\Entity
{

    public string $version;
    public \DateTimeImmutable $executedAt;
    public int $executionTime;
    public ?MigrationCandidateVO $candidate;
}
