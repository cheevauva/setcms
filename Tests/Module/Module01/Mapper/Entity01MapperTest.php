<?php

declare(strict_types=1);

namespace Tests\Module\Module01\Mapper;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Module\Module01\Mapper\Entity01ToRowMapper;
use Module\Module01\Mapper\Entity01FromRowMapper;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\Exception\Entity01MapperNotFoundKeyInRowException;

class Entity01MapperTest extends TestCase
{

    use \Tests\TestTrait;
    use \Tests\Module\Module01\Entity01HelperTestTrait;

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
