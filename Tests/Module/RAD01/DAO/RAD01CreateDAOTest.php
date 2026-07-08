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
        $create = RAD01CreateDAO::new(self::$container);
        $create->rad01 = $this->prepareEntity();
        $create->serve();

        self::assertNotEmpty(self::$qb);

        if (empty(self::$qb)) {
            return;
        }

        $sql = self::$qb->getSQL();
        $params = self::$qb->getParameters();

        self::assertStringStartsWith('INSERT INTO ' . RAD01Constants::TABLE_NAME, $sql);
        self::assertStringContainsString('id', $sql);
        self::assertStringContainsString(':id', $sql);
        self::assertStringContainsString(', field01', $sql);
        self::assertStringContainsString(', :field01', $sql);
        self::assertEquals($this->prepareRow(), $params);
    }

    #[\Override]
    protected function mocks(ContainerInterface $c): array
    {
        return [
            RAD01CreateDAO::class => fn() => new class($c) extends RAD01CreateDAO {

                use \Tests\TestDatabaseConnectionTrait;

                #[\Override]
                public function serve(): void
                {
                    RAD01CreateDAOTest::$qb = $this->createQuery();
                }
            },
        ];
    }
}
