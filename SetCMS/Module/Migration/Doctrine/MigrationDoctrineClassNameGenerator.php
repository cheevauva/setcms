<?php

declare(strict_types=1);

namespace SetCMS\Module\Migration\Doctrine;

use Doctrine\Migrations\Generator\ClassNameGenerator;
use DateTimeImmutable;
use DateTimeZone;

class MigrationDoctrineClassNameGenerator extends ClassNameGenerator
{

    #[\Override]
    public function generateClassName(string $namespace): string
    {
        return $namespace . '\\Migration' . $this->generateVersionNumber() . 'Version';
    }

    private function generateVersionNumber(): string
    {
        $now = new DateTimeImmutable('now', new DateTimeZone('UTC'));

        return $now->format(self::VERSION_FORMAT);
    }
}
