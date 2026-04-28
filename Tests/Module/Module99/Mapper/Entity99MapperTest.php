<?php

declare(strict_types=1);

namespace Tests\Module\Module99\Mapper;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\DataProvider;
use Module\Module99\Mapper\Entity99ToRowMapper;
use Module\Module99\Mapper\Entity99FromRowMapper;
use Module\Module99\Entity\Entity99Entity;
use Module\Module99\Exception\Entity99MapperNotFoundKeyInRowException;

#[Group('Module99')]
#[Group('Module99Mapper')]
class Entity99MapperTest extends \Tests\TestEasy
{

    use \Tests\Module\Module99\Entity99HelperTestTrait;

    public function testEntity99ToRowMapperSuccess(): void
    {
        $entityToRow = Entity99ToRowMapper::new(self::$container);
        $entityToRow->entity99 = $this->prepareEntity();
        $entityToRow->serve();

        self::assertEquals($this->prepareRow(), $entityToRow->row);
    }

    public function testEntity99FromRowMapperSuccess(): void
    {
        $entityFromRow = Entity99FromRowMapper::new(self::$container);
        $entityFromRow->row = $this->prepareRow();
        $entityFromRow->serve();

        self::assertEquals($this->prepareEntity(), $entityFromRow->entity99);
    }

    #[DataProvider('missingRequiredKeysProvider')]
    public function testEntity99FromRowMapperItThrowExceptionWhenRequiredKeyMissing(string $missingKey): void
    {
        $this->expectException(Entity99MapperNotFoundKeyInRowException::class);

        $row = $this->prepareRow();

        unset($row[$missingKey]);

        $entityFromRow = Entity99FromRowMapper::new(self::$container);
        $entityFromRow->row = $row;
        $entityFromRow->serve();

        self::assertEquals($this->prepareEntity(), $entityFromRow->entity99);
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
            ['field99'],
        ];
    }
}
