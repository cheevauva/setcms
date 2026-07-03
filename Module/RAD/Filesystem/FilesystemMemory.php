<?php

declare(strict_types=1);

namespace Module\RAD\Filesystem;

class FilesystemMemory extends FilesystemBase
{

    /**
     * @var array<string, mixed>
     */
    public array $fs = [];

    #[\Override]
    public function makeDir(string $directory, int $permissions = 0777, bool $recursive = false): void
    {
        $this->setNestedPathValue($this->fs, $directory, []);
    }

    #[\Override]
    public function isDir(string $directory): bool
    {
        return is_array($this->getNestedValueByPath($this->fs, $directory));
    }

    #[\Override]
    public function isFile(string $filename): bool
    {
        return !is_array($this->getNestedValueByPath($this->fs, $filename));
    }

    #[\Override]
    public function hasFile(string $filename): bool
    {
        return $this->getNestedValueByPath($this->fs, $filename) !== null;
    }

    #[\Override]
    public function fileGetContents(string $filename): string
    {
        $content = $this->getNestedValueByPath($this->fs, $filename);

        if (is_null($content)) {
            throw new \Exception($filename . ' не найден');
        }

        return $content;
    }

    #[\Override]
    public function filePutContents(string $filename, string $content): void
    {
        $this->setNestedPathValue($this->fs, $filename, $content);
    }

    #[\Override]
    public function scanDir(string $directory): array
    {
        $list = $this->getNestedValueByPath($this->fs, $directory) ?? throw new \Exception($directory . ' не найден');
        
        if (!is_array($list)) {
            throw new \Exception(sprintf('%s не папка', $directory));
        }

        return array_map(fn(string $path) => $directory . DIRECTORY_SEPARATOR . $path, array_keys($list));
    }

    #[\Override]
    public function changeMode(string $filename, int $permissions = 0777): void
    {
        
    }

    #[\Override]
    public function loadArrayFromPHPFile(string $filename): array
    {
        return json_decode($this->fileGetContents($filename), true);
    }

    /**
     * @param array<string, mixed> $array
     * @param string $path
     * @param mixed $default
     * @return mixed
     */
    protected function getNestedValueByPath(array $array, string $path, mixed $default = null): mixed
    {
        $keys = explode(DIRECTORY_SEPARATOR, $path);
        $temp = $array;
        
        foreach ($keys as $key) {
            if (is_array($temp) && array_key_exists($key, $temp)) {
                $temp = $temp[$key];
            } else {
                return $default;
            }
        }
        return $temp;
    }

    /**
     * @param array<string, mixed> $array
     * @param string $path
     * @param mixed $value
     * @return void
     */
    protected function setNestedPathValue(array &$array, string $path, mixed $value): void
    {
        $keys = explode(DIRECTORY_SEPARATOR, $path);

        $temp_ref = &$array;

        foreach ($keys as $key) {
            if (!isset($temp_ref[$key]) || !is_array($temp_ref[$key])) {
                $temp_ref[$key] = [];
            }
            $temp_ref = &$temp_ref[$key];
        }

        $temp_ref = $value;
    }

}
