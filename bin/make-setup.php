<?php

if (PHP_SAPI !== 'cli') {
    die('Только консоль');
}

$rootPath = realpath(dirname(__DIR__));

$zip = new ZipArchive();
$zip->open(dirname(__DIR__) . '/cache/setcms.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY);

foreach ($files as $name => $file) {
    if (strpos($file, '.git/') !== false) {
        continue;
    }

    if (strpos($file, dirname(__DIR__) . '/cache/') !== false) {
        continue;
    }

    if (strpos($file, dirname(__DIR__) . '/composer.phar') !== false) {
        continue;
    }

    if (!$file->isDir()) {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        $zip->addFile($filePath, $relativePath);
    }
}

$zip->close();

copy(__DIR__ . '/setup.txt', dirname(__DIR__) . '/cache/setup.php');
