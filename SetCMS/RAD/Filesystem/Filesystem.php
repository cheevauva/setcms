<?php

declare(strict_types=1);

namespace SetCMS\RAD\Filesystem;

class Filesystem extends FilesystemBase
{

    #[\Override]
    public function hasFile(string $filename): bool
    {
        return file_exists($filename);
    }

    #[\Override]
    public function loadArrayFromPHPFile(string $filename): array
    {
        return require $filename;
    }

    #[\Override]
    public function fileGetContents(string $filename): string
    {
        $content = file_get_contents($filename);

        if ($content === false) {
            throw new \Exception($filename . ' не найден');
        }
        
        return $content;
    }

    #[\Override]
    public function filePutContents(string $filename, string $content): void
    {
        file_put_contents($filename, $content);
    }

    #[\Override]
    public function changeMode(string $filename, int $permissions = 0777): void
    {
        chmod($filename, $permissions);
    }

    #[\Override]
    public function makeDir(string $directory, int $permissions = 0777, bool $recursive = false): void
    {
        mkdir($directory, $permissions, $recursive);
    }

    #[\Override]
    public function isDir(string $directory): bool
    {
        return is_dir($directory);
    }

    #[\Override]
    public function isFile(string $filename): bool
    {
        return is_file($filename);
    }

    #[\Override]
    public function scanDir(string $directory): array
    {
        return array_filter(array_map(function (string $file) use ($directory) {
            if ($file === '.' || $file === '..') {
                return;
            }

            return realpath($directory . DIRECTORY_SEPARATOR . $file);
        }, scandir($directory)));
    }
}
