<?php

declare(strict_types=1);

use SetCMS\RAD\VO\RADContextVO;
use SetCMS\RAD\Servant\RADGenerateServant;
use SetCMS\RAD\DAO\RADMetadataGetByNameDAO;
use SetCMS\RAD\Filesystem\Filesystem;

require __DIR__ . '/../bootstrap.php';

$rootPath = \SetCMS\Bootstrap::instance()->rootPath();

$template = $argv[1] ?? null;
$module = $argv[2] ?? null;
$table = $argv[3] ?? null;
$entity = $module;
$fields = array_filter(explode(',', $argv[4] ?? ''));

if (empty($template) && empty($module) || empty($table) || empty($fields)) {
    echo $argv[0] . ' template modulename tablename fields' . PHP_EOL;
    exit(1);
}

$fs = Filesystem::new($container);

$metadataByName = RADMetadataGetByNameDAO::new($container);
$metadataByName->name = $template;
$metadataByName->filesystem = $fs;
$metadataByName->serve();

$metadata = $metadataByName->metadata;

$ctx = new RADContextVO();
$ctx->moduleName = ucfirst($module);
$ctx->entityLc = lcfirst($entity);
$ctx->entityUc = ucfirst($entity);
$ctx->tableName = strtolower($table);
$ctx->rootPath = rtrim($rootPath, DIRECTORY_SEPARATOR);
$ctx->currentDate = new \DateTimeImmutable();
$ctx->fields = $fields;

$generate = RADGenerateServant::new($container);
$generate->filesystem = $fs;
$generate->ctx = $ctx;
$generate->meta = $metadata;
$generate->serve();

print_r(array_map(fn($f) => $f->path, $generate->files));
die;
