<?php

declare(strict_types=1);

require __DIR__ . '/../bootstrap.php';

$rootPath = \SetCMS\Bootstrap::instance()->rootPath();

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

$files = getFiles(sprintf('%s/Module/Module01/', $rootPath));
$files[] = sprintf('%s/resources/acl/entity01lc.php', $rootPath);
$files[] = sprintf('%s/resources/routes/entity01lc.php', $rootPath);
$files[] = sprintf('%s/resources/migrations/sqlite/main/u.Ymdhis.Table01.sql', $rootPath);
$files[] = sprintf('%s/resources/migrations/sqlite/main/d.Ymdhis.Table01.sql', $rootPath);
$files[] = sprintf('%s/resources/templates/themes/bootstrap5/Entity01PrivateIndex.twig', $rootPath);
$files[] = sprintf('%s/resources/templates/themes/bootstrap5/Entity01PrivateEdit.twig', $rootPath);
$files[] = sprintf('%s/resources/templates/themes/bootstrap5/Entity01PrivateRead.twig', $rootPath);

$module = $argv[1] ?? null;
$table = $argv[2] ?? null;
$entity = $module;
$fields = array_filter(explode(',', $argv[3] ?? ''));

if (empty($module) || empty($table) || empty($fields)) {
    echo $argv[0] . ' modulename tablename fields' . PHP_EOL;
    exit(1);
}

$parts = [
    'Ymdhis' => date('YmdHis'),
    'Module01' => ucfirst($module),
    'entity01lc' => lcfirst($entity),
    'Entity01' => ucfirst($module),
    'Table01' => strtolower($table),
];

foreach ($files as $file) {
    $source = $file;
    $target = strtr($file, $parts);

    if (is_dir($source) && !is_dir($target)) {
        mkdir($target, 0777, true);
        continue;
    }

    if (file_exists($target)) {
        continue;
    }

    $targetContent = strtr(file_get_contents($source), $parts);

    $lines = [];

    foreach (explode("\n", $targetContent) as $index => $line) {
        if (strpos($line, 'field01') !== false) {
            foreach ($fields as $field) {
                $lines[] = str_replace('field01', $field, $line);
            }
            continue;
        }

        $lines[] = $line;
    }

    if (!file_exists($target)) {
        file_put_contents($target, implode("\n", $lines));
    }
    
    chmod($target, 0777);
}
