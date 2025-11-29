<?php

declare(strict_types=1);

namespace Tests\Module\Module01\Mapper;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use SetCMS\UUID;
use Module\Module01\Mapper\Entity01ToRowMapper;
use Module\Module01\Mapper\Entity01FromRowMapper;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\Exception\Entity01MapperNotFoundKeyInRowException;

class Entity01MapperTest extends TestCase
{

    use \Tests\TestTrait;

    /**
     * @return array<string, mixed>
     */
    protected function prepareRow(): array
    {
        return [
            'id' => '331c1832-d5e1-43a6-aef0-6fa6ffbe01a6',
            'entity_type' => 'entity01lc',
            'date_created' => '2025-11-29 19:56:10',
            'date_modified' => '2025-11-29 19:56:10',
            'deleted' => 0,
            'field01' => 'field01',
        ];
    }

    protected function prepareEntity(): Entity01Entity
    {
        $entity = new Entity01Entity();
        $entity->id = new UUID('331c1832-d5e1-43a6-aef0-6fa6ffbe01a6');
        $entity->dateCreated = new \DateTimeImmutable('2025-11-29 19:56:10');
        $entity->dateModified = new \DateTimeImmutable('2025-11-29 19:56:10');
        $entity->deleted = false;
        $entity->field01 = 'field01';

        return $entity;
    }

    public function testEntity01ToRowMapperSuccess(): void
    {
        $entityToRow = Entity01ToRowMapper::new($this->container($this->mocks()));
        $entityToRow->entity = $this->prepareEntity();
        $entityToRow->serve();

        self::assertEquals($this->prepareRow(), $entityToRow->row);
    }

    public function testEntity01FromRowMapperSuccess(): void
    {
        $entityFromRow = Entity01FromRowMapper::new($this->container($this->mocks()));
        $entityFromRow->row = $this->prepareRow();
        $entityFromRow->serve();

        self::assertEquals($this->prepareEntity(), $entityFromRow->entity);
    }

    #[DataProvider('missingRequiredKeysProvider')]
    public function testEntity01FromRowMapperItThrowExceptionWhenRequiredKeyMissing(string $missingKey): void
    {
        $this->expectException(Entity01MapperNotFoundKeyInRowException::class);

        $row = $this->prepareRow();

        unset($row[$missingKey]);

        $entityFromRow = Entity01FromRowMapper::new($this->container($this->mocks()));
        $entityFromRow->row = $row;
        $entityFromRow->serve();

        self::assertEquals($this->prepareEntity(), $entityFromRow->entity);
    }

    /**
     * @return array<int, array<int, string>>
     */
    public static function missingRequiredKeysProvider(): array
    {
        return [
            ['id'],
            ['entity_type'],
            ['date_created'],
            ['date_modified'],
            ['deleted'],
            ['field01'],
        ];
    }

    /**
     * @return \Closure
     */
    protected function mocks(): \Closure
    {
        return fn() => [
            'entities' => [
                'entity01lc' => Entity01Entity::class,
            ],
        ];
    }
}
