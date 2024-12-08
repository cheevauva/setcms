<?php

declare(strict_types=1);

namespace SetCMS\Module\Migration\Doctrine;

use Doctrine\Migrations\Finder\Finder;

class MigrationDoctrineCustomGlobFinder extends Finder
{

    #[\Override]
    public function findMigrations(string $directory, string|null $namespace = null): array
    {
        $dir = $this->getRealPath($directory);

        $files = glob(rtrim($dir, '/') . '/Migration*Version.php');
        if ($files === false) {
            $files = [];
        }

        return $this->loadMigrations($files, $namespace);
    }
}
