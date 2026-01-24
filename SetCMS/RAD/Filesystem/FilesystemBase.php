<?php

declare(strict_types=1);

namespace SetCMS\RAD\Filesystem;

abstract class FilesystemBase
{

    use \UUA\Traits\BuildTrait;
    use \UUA\Traits\ContainerTrait;

    abstract public function hasFile(string $filename): bool;

    /**
     * @param string $filename
     * @return array<mixed, mixed>
     */
    abstract public function loadArrayFromPHPFile(string $filename): array;

    abstract public function fileGetContents(string $filename): string;

    abstract public function filePutContents(string $filename, string $content): void;

    abstract public function changeMode(string $filename, int $permissions = 0777): void;

    abstract public function makeDir(string $directory, int $permissions = 0777, bool $recursive = false): void;

    abstract public function isDir(string $directory): bool;

    abstract public function isFile(string $filename): bool;

    /**
     * @return array<string>
     */
    abstract public function scanDir(string $directory): array;

    /**
     * @param string $directory
     * @param array<string> $files
     * @return array<string>
     */
    public function getFiles(string $directory, array $files = []): array
    {
        foreach ($this->scanDir($directory) as $path) {
            if (!$this->isDir($path)) {
                $files[] = $path;
            }

            if ($this->isDir($path)) {
                $files[] = $path;
                $files = $this->getFiles($path, $files);
            }
        }

        return $files;
    }
}
