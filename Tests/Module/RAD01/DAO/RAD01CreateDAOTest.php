<?php

declare(strict_types=1);

namespace Tests\Module\RAD01\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\Database\DatabaseQueryBuilder;
use Module\RAD01\RAD01Constants;
use Module\RAD01\DAO\RAD01CreateDAO;
use Module\RAD01\Entity\RAD01Entity;

class RAD01CreateDAOTest extends \Tests\TestEasy
{

    use \Tests\Module\RAD01\RAD01HelperTestTrait;

    public static ?DatabaseQueryBuilder $qb = null;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        self::$qb = null;
    }

    public function testRAD01CreateDAO(): void
    {
        RAD01CreateDAO::call(self::$container, $this->prepareEntity());

        self::assertNotEmpty(self::$qb);

        $sql = self::$qb?->getSQL() ?? '';
        $params = self::$qb?->getParameters();

        self::assertStringStartsWith('INSERT INTO ' . RAD01Constants::TABLE_NAME, $sql);
        self::assertStringContainsString('field01, id', $sql);
        self::assertStringContainsString(':field01, :id', $sql);
        self::assertEquals($this->prepareRow(), $params);
    }

    #[\Override]
    protected function mocks(ContainerInterface $c): array
    {
        return [
            RAD01CreateDAO::class => fn() => new class($c) extends RAD01CreateDAO {

                use \Tests\TestDatabaseConnectionTrait;

                #[\Override]
                protected function createQuery(): DatabaseQueryBuilder
                {
                    RAD01CreateDAOTest::$qb = parent::createQuery();

                    return $this->db()->createQueryBuilder()->select('1');
                }
            },
        ];
    }
}
