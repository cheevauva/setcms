<?php

declare(strict_types=1);

define('ROOT_PATH', dirname(__DIR__));

function getFiles(string $directory, array $files = [])
{
    foreach (scandir($directory) as $file) {
        $path = realpath($directory . DIRECTORY_SEPARATOR . $file);

        if (!is_dir($path)) {
            $files[] = $path;
        } else if ($file != "." && $file != "..") {
            $files[] = $path;
            $files = getFiles($path, $files);
        }
    }

    return $files;
}

$files = getFiles(sprintf('%s/src/SetCMS/Module/Module01/', ROOT_PATH));
$module = $argv[1] ?? null;
$entity = $argv[2] ?? null;
$table = $argv[3] ?? null;

if (empty($module) || empty($entity) || empty($table)) {
    echo $argv[0] . ' modulename entityname tablename' . PHP_EOL;
    exit(1);
}

foreach ($files as $file) {
    $source = $file;
    $target = strtr($file, [
        'Module01' => $module,
        'Entity01' => $entity
    ]);

    if (is_dir($source) && !is_dir($target)) {
        mkdir($target, 0777, true);
        continue;
    }

    if (file_exists($target)) {
        continue;
    }

    $targetContent = strtr(file_get_contents($source), [
        'Module01' => $module,
        'Entity01' => $entity,
        'Table01' => $table,
    ]);

    file_put_contents($target, $targetContent);
}
