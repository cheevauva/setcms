<?php

declare(strict_types=1);

namespace Tests\Module\RAD01\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\Database\DatabaseQueryBuilder;
use Module\RAD01\RAD01Constants;
use Module\RAD01\DAO\RAD01UpdateDAO;
use Module\RAD01\Entity\RAD01Entity;

class RAD01UpdateDAOTest extends \Tests\TestEasy
{

    use \Tests\Module\RAD01\RAD01HelperTestTrait;

    public static ?DatabaseQueryBuilder $qb = null;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        self::$qb = null;
    }

    public function testRAD01UpdateDAO(): void
    {
        RAD01UpdateDAO::call(self::$container, $this->prepareEntity());

        self::assertNotEmpty(self::$qb);

        $sql = self::$qb?->getSQL() ?? '';
        $params = self::$qb?->getParameters();

        self::assertStringStartsWith('UPDATE ' . RAD01Constants::TABLE_NAME, $sql);
        self::assertStringContainsString('id = :id', $sql);
        self::assertStringContainsString('field01 = :field01', $sql);
        self::assertEquals($this->prepareRow(), $params);
    }

    #[\Override]
    protected function mocks(ContainerInterface $c): array
    {
        return [
            RAD01UpdateDAO::class => fn() => new class($c) extends RAD01UpdateDAO {

                use \Tests\TestDatabaseConnectionTrait;

                #[\Override]
                protected function createQuery(): DatabaseQueryBuilder
                {
                    RAD01UpdateDAOTest::$qb = parent::createQuery();

                    return $this->db()->createQueryBuilder()->select('1');
                }
            },
        ];
    }
}
