<?php

declare(strict_types=1);

$container = require '../bootstrap.php';

$rootPath = \SetCMS\Bootstrap::instance()->rootPath() ;

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

$files = getFiles(sprintf('%s/SetCMS/Module/Module01/', $rootPath));
$files[] = sprintf('%s/resources/acl/Entity01LC.php', $rootPath);
$files[] = sprintf('%s/resources/routes/Entity01LC.php', $rootPath);
$files[] = sprintf('%s/SetCMS/Module/Migration/Version/Main/MigrationYmdhisVersion.php', $rootPath);
$files[] = sprintf('%s/resources/templates/themes/bootstrap5/Entity01PrivateIndex.twig', $rootPath);
$files[] = sprintf('%s/resources/templates/themes/bootstrap5/Entity01PrivateEdit.twig', $rootPath);
$files[] = sprintf('%s/resources/templates/themes/bootstrap5/Entity01PrivateRead.twig', $rootPath);

$module = $argv[1] ?? null;
$entity = $argv[2] ?? null;
$table = $argv[3] ?? null;
$fields = array_filter(explode(',', $argv[4] ?? ''));

if (empty($module) || empty($entity) || empty($table) || empty($fields)) {
    echo $argv[0] . ' modulename entityname tablename fields' . PHP_EOL;
    exit(1);
}

$parts = [
    'Ymdhis' => date('YmdHis'),
    'Module01' => $module,
    'Entity01LC' => lcfirst($entity),
    'Entity01' => $entity,
    'Table01' => $table,
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

    file_put_contents($target, implode("\n", $lines));
    chmod($target, 0777);
}
