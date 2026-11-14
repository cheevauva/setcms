<?php

declare(strict_types=1);

namespace Tests\Module\RAD01\Mapper;

use PHPUnit\Framework\Attributes\DataProvider;
use Module\RAD01\Mapper\RAD01ToRowMapper;
use Module\RAD01\Mapper\RAD01FromRowMapper;

class RAD01MapperTest extends \Tests\TestEasy
{

    use \Tests\Module\RAD01\RAD01HelperTestTrait;

    public function testRAD01ToRowMapperSuccess(): void
    {
        self::assertEquals($this->prepareRow(), RAD01ToRowMapper::call(self::$container, $this->prepareEntity())->row);
    }

    public function testRAD01FromRowMapperSuccess(): void
    {
        self::assertEquals($this->prepareEntity(), RAD01FromRowMapper::call(self::$container, $this->prepareRow())->entity);
    }

    #[DataProvider('missingRequiredKeysProvider')]
    public function testRAD01FromRowMapperItThrowExceptionWhenRequiredKeyMissing(string $missingKey): void
    {
        $this->expectExceptionMessage(sprintf('Не найден ключ %s в массиве row', $missingKey));

        $row = $this->prepareRow();

        unset($row[$missingKey]);

        RAD01FromRowMapper::call(self::$container, $row)->entity;
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
