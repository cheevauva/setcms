<?php

declare(strict_types=1);

namespace SetCMS\Database;

use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;
use Psr\EventDispatcher\EventDispatcherInterface;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Logging\Middleware;
use SetCMS\Database\Event\DatabaseDebugEvent;
use SetCMS\Database\DatabaseDriverManager;

class DatabaseFactory
{

    /**
     * @var array<string, Database>
     */
    protected array $databases = [];

    use \UUA\Traits\BuildTrait;
    use \UUA\Traits\ContainerTrait;
    use \UUA\Traits\EnvTrait;
    use \UUA\Traits\EventDispatcherTrait;

    public function make(string $name): Database
    {
        if (isset($this->databases[$name])) {
            return $this->databases[$name];
        }

        $className = Database::class;
        $prefix = sprintf('DATABASE%s_', mb_strtoupper($name));
        $driver = $this->env()[$prefix . 'DRIVER'];
        $env = $this->env();

        switch ($driver) {
            case 'pdo_sqlite':
                $params = [
                    'wrapperClass' => $className,
                    'path' => $env[$prefix . 'PATH'],
                    'driver' => $driver,
                    'charset' => 'UTF8',
                ];
                break;
            case 'pdo_pgsql':
            case 'pdo_mysql':
                $params = [
                    'wrapperClass' => $className,
                    'dbname' => $this->env()[$prefix . 'DBNAME'],
                    'user' => $this->env()[$prefix . 'USER'],
                    'password' => $this->env()[$prefix . 'PASSWORD'],
                    'host' => $this->env()[$prefix . 'HOST'],
                    'port' => $this->env()[$prefix . 'PORT'],
                    'driver' => $driver,
                    'charset' => 'UTF8',
                ];
                break;
            default:
                throw new \RuntimeException(sprintf('driver %s not supported', $driver));
        }

        $db = DatabaseDriverManager::getConnection($params, $this->config($name));
        $db->connectionName = $name;

        return $this->databases[$name] = $db;
    }

    private function config(string $type): Configuration
    {
        $configuration = new Configuration();
        $configuration->setMiddlewares([new Middleware($this->prepareLogger($type))]);

        return $configuration;
    }

    private function prepareLogger(string $connectionName): AbstractLogger
    {
        return new class($connectionName, $this->eventDispatcher()) extends AbstractLogger {

            public function __construct(protected string $connectionName, protected EventDispatcherInterface $eventDispatcher)
            {
                
            }

            #[\Override]
            public function log($level, string|\Stringable $message, array $context = []): void
            {
                if ($level === LogLevel::DEBUG) {
                    (new DatabaseDebugEvent($this->connectionName . ', ' . $message, $context))->dispatch($this->eventDispatcher);
                }
            }
        };
    }
}
