<?php

declare(strict_types=1);

namespace Tests\Module\Module01\Mapper;

use PHPUnit\Framework\Attributes\DataProvider;
use Module\Module01\Mapper\Entity01ToRowMapper;
use Module\Module01\Mapper\Entity01FromRowMapper;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\Exception\Entity01MapperNotFoundKeyInRowException;

class Entity01MapperTest extends \Tests\TestEasy
{

    use \Tests\Module\Module01\Entity01HelperTestTrait;

    public function testEntity01ToRowMapperSuccess(): void
    {
        $entityToRow = Entity01ToRowMapper::new(self::$container);
        $entityToRow->entity01 = $this->prepareEntity();
        $entityToRow->serve();

        self::assertEquals($this->prepareRow(), $entityToRow->row);
    }

    public function testEntity01FromRowMapperSuccess(): void
    {
        $entityFromRow = Entity01FromRowMapper::new(self::$container);
        $entityFromRow->row = $this->prepareRow();
        $entityFromRow->serve();

        self::assertEquals($this->prepareEntity(), $entityFromRow->entity01);
    }

    #[DataProvider('missingRequiredKeysProvider')]
    public function testEntity01FromRowMapperItThrowExceptionWhenRequiredKeyMissing(string $missingKey): void
    {
        $this->expectException(Entity01MapperNotFoundKeyInRowException::class);

        $row = $this->prepareRow();

        unset($row[$missingKey]);

        $entityFromRow = Entity01FromRowMapper::new(self::$container);
        $entityFromRow->row = $row;
        $entityFromRow->serve();

        self::assertEquals($this->prepareEntity(), $entityFromRow->entity01);
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
