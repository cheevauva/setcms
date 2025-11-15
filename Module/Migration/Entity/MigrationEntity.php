<?php

declare(strict_types=1);

namespace Module\Migration\Entity;

use Module\Migration\VO\MigrationCandidateVO;

class MigrationEntity extends \SetCMS\Entity\Entity
{

    public string $version;
    public \DateTimeImmutable $executedAt;
    public int $executionTime;
    public ?MigrationCandidateVO $candidate;
}
