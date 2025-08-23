<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    die('Только консоль');
}

exec('rm -rf ' . __DIR__ . '/../cache/ez');
mkdir(__DIR__ . '/../cache/ez', 0777);

$composerJson = json_decode(file_get_contents(__DIR__ . '/../composer.json'), true);

unset($composerJson['require-dev']);

file_put_contents(__DIR__ . '/../cache/ez/composer.json', json_encode($composerJson, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

chmod(__DIR__ . '/../cache/ez/composer.json', 0777);

exec('composer install --prefer-dist --no-dev --no-scripts --no-plugins --no-interaction --no-progress --working-dir=/setcms/cache/ez');

$rootPath = realpath(dirname(__DIR__));

/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY);

$ignoreItems = [
    '.env',
    '.env.dist',
    'Makefile',
    '.gitignore',
    'composer.json',
    'composer.lock',
    'phpstan-baseline.neon',
    'phpstan.neon',
    'phpunit.xml',
    '.phpunit.cache',
    'favicon.ico',
    dirname(__DIR__) . '/.git',
    dirname(__DIR__) . '/docker',
    dirname(__DIR__) . '/js/',
    dirname(__DIR__) . '/css',
    dirname(__DIR__) . '/bin',
    dirname(__DIR__) . '/resources',
    dirname(__DIR__) . '/vendor',
    dirname(__DIR__) . '/cache',
    dirname(__DIR__) . '/composer.phar',
];

$files2 = [];

foreach ($files as $name => $file) {
    foreach ($ignoreItems as $ignoreItem) {
        if (strpos($file->getRealPath(), $ignoreItem) !== false) {
            continue 2;
        }
    }

    if (!$file->isDir()) {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        $files2[$filePath] = $relativePath;
    }
}

foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(realpath(dirname(__DIR__) . '/cache/ez/vendor')), RecursiveIteratorIterator::LEAVES_ONLY) as $name => $file) {
    if (!$file->isDir()) {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        $files2[$filePath] = str_replace('cache/vendor', 'vendor', $relativePath);
    }
}

$pharFilename = dirname(__DIR__) . '/cache/ez/setcms.phar';


$phar = new Phar($pharFilename);
$phar->startBuffering();

foreach ($files2 as $filename => $localName) {
    $phar->addFile($filename, $localName);
    
    echo 'added ' . $localName . "\n";
}

$phar->stopBuffering();


file_put_contents(__DIR__ . '/../cache/ez/index.php', "<?php declare(strict_types=1);require_once 'setcms.phar';");

exec('rm -rf ' . __DIR__ . '/../cache/ez/vendor');
exec('rm -rf ' . __DIR__ . '/../cache/ez/composer.lock');
exec('rm -rf ' . __DIR__ . '/../cache/ez/composer.json');
exec('cp -R ' . __DIR__ . '/../css/ ' . __DIR__ . '/../cache/ez/css/');
exec('cp -R ' . __DIR__ . '/../js/ ' . __DIR__ . '/../cache/ez/js/');
exec('cp -R ' . __DIR__ . '/../resources/ ' . __DIR__ . '/../cache/ez/resources/');
exec('mkdir ' . __DIR__ . '/../cache/ez/cache/');
exec('chmod 777 ' . __DIR__ . '/../cache/ez/ -R');
