<?php

declare(strict_types=1);

namespace Tests\Module\Module01\DAO;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use SetCMS\Database\DatabaseQueryBuilder;
use Module\Module01\Module01Constants;
use Module\Module01\DAO\Entity01CreateDAO;
use Module\Module01\Entity\Entity01Entity;

class Entity01CreateDAOTest extends TestCase
{

    use \Tests\TestTrait;
    use \Tests\Module\Module01\Entity01HelperTestTrait;

    public static ?DatabaseQueryBuilder $qb = null;

    #[\Override]
    protected function setUp(): void
    {
        self::$qb = null;
    }

    public function testEntity01CreateDAO(): void
    {
        $create = Entity01CreateDAO::new($this->container($this->mocks()));
        $create->entity = $this->prepareEntity();
        $create->serve();

        self::assertNotEmpty(self::$qb);

        if (empty(self::$qb)) {
            return;
        }

        $sql = self::$qb->getSQL();
        $params = self::$qb->getParameters();

        self::assertStringStartsWith('INSERT INTO ' . Module01Constants::TABLE_NAME, $sql);
        self::assertStringContainsString('id, created_by, modified_by, assigned_by, entity_type, date_created, date_modified, deleted', $sql);
        self::assertStringContainsString(':id, :created_by, :modified_by, :assigned_by, :entity_type, :date_created, :date_modified, :deleted', $sql);
        self::assertStringContainsString(', field01', $sql);
        self::assertStringContainsString(', :field01', $sql);
        self::assertEquals($this->prepareRow(), $params);
    }

    /**
     * @return \Closure
     */
    protected function mocks(): \Closure
    {
        return fn(ContainerInterface $container) => [
            'entities' => [
                'entity01lc' => Entity01Entity::class,
            ],
            Entity01CreateDAO::class => fn($container) => new class($container) extends Entity01CreateDAO {

                use \Tests\TestDatabaseConnectionTrait;

                #[\Override]
                protected function insertRow(): void
                {
                    Entity01CreateDAOTest::$qb = $this->createQuery();
                }
            },
        ];
    }
}
