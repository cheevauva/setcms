<?php

declare(strict_types=1);

namespace SetCMS\Mapper;

use SetCMS\UUID;
use Psr\Container\ContainerInterface;

abstract class MapperFromRow extends \UUA\Mapper
{

    /**
     * @var array<string, mixed>
     */
    public array $row;

    protected function uuid(string $key): UUID
    {
        return new UUID(strval($this->row[$key] ?? throw $this->notFoundKeyInRowException($key)));
    }

    protected function string(string $key): string
    {
        return strval($this->row[$key] ?? throw $this->notFoundKeyInRowException($key));
    }

    protected function dateTime(string $key): \DateTimeImmutable
    {
        return new \DateTimeImmutable(strval($this->row[$key] ?? throw $this->notFoundKeyInRowException($key)));
    }

    protected function dateTimeOrNull(string $key): ?\DateTimeImmutable
    {
        return isset($this->row[$key]) ? new \DateTimeImmutable(strval($this->row[$key])) : null;
    }

    protected function bool(string $key): bool
    {
        return boolval($this->row[$key] ?? throw $this->notFoundKeyInRowException($key));
    }

    protected function int(string $key): int
    {
        return intval($this->row[$key] ?? throw $this->notFoundKeyInRowException($key));
    }

    /**
     * @param string $key
     * @return array<mixed, mixed>|array<mixed>
     */
    protected function json(string $key): array
    {
        return json_decode($this->row[$key] ?? throw $this->notFoundKeyInRowException($key), true);
    }

    abstract protected function notFoundKeyInRowException(string $key): \Throwable;

    /**
     * @param ContainerInterface $container
     * @param array<string, mixed> $row
     * @return static
     */
    public static function call(ContainerInterface $container, array $row): self
    {
        $self = static::new($container);
        $self->row = $row;
        $self->serve();

        return $self;
    }
}
