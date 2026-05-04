<?php

declare(strict_types=1);

namespace Tests\Module\Module01\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\Database\DatabaseQueryBuilder;
use Module\Module01\Module01Constants;
use Module\Module01\DAO\Entity01UpdateDAO;
use Module\Module01\Entity\Entity01Entity;

class Entity01UpdateDAOTest extends \Tests\TestEasy
{

    use \Tests\Module\Module01\Entity01HelperTestTrait;

    public static ?DatabaseQueryBuilder $qb = null;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        
        self::$qb = null;
    }

    public function testEntity01UpdateDAO(): void
    {
        $create = Entity01UpdateDAO::new(self::$container);
        $create->entity01 = $this->prepareEntity();
        $create->serve();

        self::assertNotEmpty(self::$qb);

        if (empty(self::$qb)) {
            return;
        }

        $sql = self::$qb->getSQL();
        $params = self::$qb->getParameters();

        self::assertStringStartsWith('UPDATE ' . Module01Constants::TABLE_NAME, $sql);
        self::assertStringContainsString('id = :id', $sql);
        self::assertStringContainsString('field01 = :field01', $sql);
        self::assertEquals($this->prepareRow(), $params);
    }

    #[\Override]
    protected function mocks(ContainerInterface $c): array
    {
        return [
            Entity01UpdateDAO::class => fn() => new class($c) extends Entity01UpdateDAO {

                use \Tests\TestDatabaseConnectionTrait;

                #[\Override]
                public function serve(): void
                {
                    Entity01UpdateDAOTest::$qb = $this->createQuery();
                }
            },
        ];
    }
}
