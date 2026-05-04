<?php

declare(strict_types=1);

namespace Tests\Module\Module01\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\Database\DatabaseQueryBuilder;
use Module\Module01\Module01Constants;
use Module\Module01\DAO\Entity01CreateDAO;
use Module\Module01\Entity\Entity01Entity;

class Entity01CreateDAOTest extends \Tests\TestEasy
{

    use \Tests\Module\Module01\Entity01HelperTestTrait;

    public static ?DatabaseQueryBuilder $qb = null;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        
        self::$qb = null;
    }

    public function testEntity01CreateDAO(): void
    {
        $create = Entity01CreateDAO::new(self::$container);
        $create->entity01 = $this->prepareEntity();
        $create->serve();

        self::assertNotEmpty(self::$qb);

        if (empty(self::$qb)) {
            return;
        }

        $sql = self::$qb->getSQL();
        $params = self::$qb->getParameters();

        self::assertStringStartsWith('INSERT INTO ' . Module01Constants::TABLE_NAME, $sql);
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
            Entity01CreateDAO::class => fn() => new class($c) extends Entity01CreateDAO {

                use \Tests\TestDatabaseConnectionTrait;

                #[\Override]
                public function serve(): void
                {
                    Entity01CreateDAOTest::$qb = $this->createQuery();
                }
            },
        ];
    }
}
