<?php

declare(strict_types=1);

namespace Tests\Module\RAD99\Mapper;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\DataProvider;
use Module\RAD99\Mapper\RAD99ToRowMapper;
use Module\RAD99\Mapper\RAD99FromRowMapper;
use Module\RAD99\Entity\RAD99Entity;
use Module\RAD99\Exception\RAD99MapperNotFoundKeyInRowException;

#[Group('RAD99')]
#[Group('RAD99Mapper')]
class RAD99MapperTest extends \Tests\TestEasy
{

    use \Tests\Module\RAD99\RAD99HelperTestTrait;

    public function testRAD99ToRowMapperSuccess(): void
    {
        $entityToRow = RAD99ToRowMapper::new(self::$container);
        $entityToRow->rad99 = $this->prepareEntity();
        $entityToRow->serve();

        self::assertEquals($this->prepareRow(), $entityToRow->row);
    }

    public function testRAD99FromRowMapperSuccess(): void
    {
        $entityFromRow = RAD99FromRowMapper::new(self::$container);
        $entityFromRow->row = $this->prepareRow();
        $entityFromRow->serve();

        self::assertEquals($this->prepareEntity(), $entityFromRow->rad99);
    }

    #[DataProvider('missingRequiredKeysProvider')]
    public function testRAD99FromRowMapperItThrowExceptionWhenRequiredKeyMissing(string $missingKey): void
    {
        $this->expectException(RAD99MapperNotFoundKeyInRowException::class);

        $row = $this->prepareRow();

        unset($row[$missingKey]);

        $entityFromRow = RAD99FromRowMapper::new(self::$container);
        $entityFromRow->row = $row;
        $entityFromRow->serve();

        self::assertEquals($this->prepareEntity(), $entityFromRow->rad99);
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
