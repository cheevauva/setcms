<?php

declare(strict_types=1);

use SetCMS\Database\DatabaseFactory;
use SetCMS\Module\Migration\Servant\MigrationUpServant;
use SetCMS\Module\Migration\Servant\MigrationDownServant;
use SetCMS\Module\Migration\VO\MigrationCandidateVO;

define('ROOT_PATH', dirname(__DIR__));

while (true) {
    if (file_exists(ROOT_PATH . '/vendor/autoload.php')) {
        break;
    } else {
        sleep(1);
    }
}

require ROOT_PATH . '/bootstrap.php';

$action = strval($argv[1] ?? throw new \Exception('Не указан параметр действия'));
$name = strval($argv[2] ?? throw new \Exception('Не указан параметр бд'));

$connection = DatabaseFactory::singleton($container)->make($name);

while (true) {
    try {
        // ждем пока бд подниментся (на деве, на проде уже должно быть все подня)
        $connection->executeQuery('SELECT 1');
        break;
    } catch (Exception $ex) {
        sleep(1);
    }
}

switch ($action) {
    case 'generate':
        $id = $argv[2] ?? throw new \Exception('Не указан параметр названия миграции');

        file_put_contents(sprintf($basePath . 'u.%s.%s.sql', gmdate('YmdHis'), $id), '');
        file_put_contents(sprintf($basePath . 'd.%s.%s.sql', gmdate('YmdHis'), $id), '');
        chmod(sprintf($basePath . 'u.%s.%s.sql', gmdate('YmdHis'), $id), 0777);
        chmod(sprintf($basePath . 'd.%s.%s.sql', gmdate('YmdHis'), $id), 0777);
        break;
    case 'down':
        $down = MigrationUpServant::new($container);
        $down->dbName = $name;
        $down->serve();
        break;
    case 'up':
        $up = MigrationUpServant::new($container);
        $up->dbName = $name;
        $up->serve();

        foreach ($up->executedNew as $candidate) {
            $candidate = MigrationCandidateVO::as($candidate);

            echo 'Done: ' . $candidate->file . "\n";
        }
        foreach ($up->failded as $candidate) {
            $candidate = MigrationCandidateVO::as($candidate);

            echo sprintf("Failed (%s): %s(%s): %s\n", $candidate->file, $candidate->error->getFile(), $candidate->error->getLine(), $candidate->error->getMessage());
        }

        exit(intval(!empty($up->failded)));
        break;
    default:
        throw new \Exception($argv[1] . ' неизвестная команда');
}
