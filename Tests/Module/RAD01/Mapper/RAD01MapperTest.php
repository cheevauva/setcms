<?php

declare(strict_types=1);

namespace Tests\Module\RAD01\Mapper;

use PHPUnit\Framework\Attributes\DataProvider;
use Module\RAD01\Mapper\RAD01ToRowMapper;
use Module\RAD01\Mapper\RAD01FromRowMapper;
use Module\RAD01\Entity\RAD01Entity;
use Module\RAD01\Exception\RAD01MapperNotFoundKeyInRowException;

class RAD01MapperTest extends \Tests\TestEasy
{

    use \Tests\Module\RAD01\RAD01HelperTestTrait;

    public function testRAD01ToRowMapperSuccess(): void
    {
        $entityToRow = RAD01ToRowMapper::new(self::$container);
        $entityToRow->rad01 = $this->prepareEntity();
        $entityToRow->serve();

        self::assertEquals($this->prepareRow(), $entityToRow->row);
    }

    public function testRAD01FromRowMapperSuccess(): void
    {
        $entityFromRow = RAD01FromRowMapper::new(self::$container);
        $entityFromRow->row = $this->prepareRow();
        $entityFromRow->serve();

        self::assertEquals($this->prepareEntity(), $entityFromRow->rad01);
    }

    #[DataProvider('missingRequiredKeysProvider')]
    public function testRAD01FromRowMapperItThrowExceptionWhenRequiredKeyMissing(string $missingKey): void
    {
        $this->expectException(RAD01MapperNotFoundKeyInRowException::class);

        $row = $this->prepareRow();

        unset($row[$missingKey]);

        $entityFromRow = RAD01FromRowMapper::new(self::$container);
        $entityFromRow->row = $row;
        $entityFromRow->serve();

        self::assertEquals($this->prepareEntity(), $entityFromRow->rad01);
    }

    /**
     * @return array<int, array<int, string>>
     */
    public static function missingRequiredKeysProvider(): array
    {
        return [
            ['id'],
            ['field01'],
        ];
    }
}
