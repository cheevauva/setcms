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
        self::assertEquals($this->prepareRow(), RAD99ToRowMapper::call(self::$container, $this->prepareEntity())->row);
    }

    public function testRAD99FromRowMapperSuccess(): void
    {
        self::assertEquals($this->prepareEntity(), RAD99FromRowMapper::call(self::$container, $this->prepareRow())->entity);
    }

    #[DataProvider('missingRequiredKeysProvider')]
    public function testRAD99FromRowMapperItThrowExceptionWhenRequiredKeyMissing(string $missingKey): void
    {
        $this->expectException(RAD99MapperNotFoundKeyInRowException::class);

        $row = $this->prepareRow();

        unset($row[$missingKey]);

        self::assertEquals($this->prepareEntity(), RAD99FromRowMapper::call(self::$container, $row)->entity);
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
