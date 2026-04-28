<?php

declare(strict_types=1);

namespace SetCMS\Mapper;

use Psr\Container\ContainerInterface;
use SetCMS\Entity\Entity;
use SetCMS\UUID;

trait MapperEntityFromRowTrait
{

    /**
     * @var array<string, mixed>
     */
    public array $row;

    abstract protected function notFoundKeyInRowException(string $key): \Throwable;

    private function mappingDefault(Entity $entity): void
    {
        $entity->id = $this->uuid('id');
    }

    private function uuid(string $key): UUID
    {
        return new UUID(strval($this->row[$key] ?? throw $this->notFoundKeyInRowException($key)));
    }

    private function string(string $key): string
    {
        return strval($this->row[$key] ?? throw $this->notFoundKeyInRowException($key));
    }

    private function dateTime(string $key): \DateTimeImmutable
    {
        return new \DateTimeImmutable(strval($this->row[$key] ?? throw $this->notFoundKeyInRowException($key)));
    }

    private function dateTimeOrNull(string $key): ?\DateTimeImmutable
    {
        return isset($this->row[$key]) ? new \DateTimeImmutable(strval($this->row[$key])) : null;
    }

    private function bool(string $key): bool
    {
        return boolval($this->row[$key] ?? throw $this->notFoundKeyInRowException($key));
    }

    private function int(string $key): int
    {
        return intval($this->row[$key] ?? throw $this->notFoundKeyInRowException($key));
    }

    /**
     * @param string $key
     * @return array<mixed, mixed>|array<mixed>
     */
    private function json(string $key): array
    {
        return json_decode($this->row[$key] ?? throw $this->notFoundKeyInRowException($key), true);
    }

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
