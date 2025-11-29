<?php

declare(strict_types=1);

namespace Tests\Module\Module01\DAO;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use SetCMS\Database\DatabaseQueryBuilder;
use Module\Module01\Module01Constants;
use Module\Module01\DAO\Entity01UpdateDAO;
use Module\Module01\Entity\Entity01Entity;

class Entity01UpdateDAOTest extends TestCase
{

    use \Tests\TestTrait;
    use \Tests\Module\Module01\Entity01HelperTestTrait;

    public static ?DatabaseQueryBuilder $qb = null;

    #[\Override]
    protected function setUp(): void
    {
        self::$qb = null;
    }

    public function testEntity01UpdateDAO(): void
    {
        $create = Entity01UpdateDAO::new($this->container($this->mocks()));
        $create->entity = $this->prepareEntity();
        $create->serve();

        self::assertNotEmpty(self::$qb);

        if (empty(self::$qb)) {
            return;
        }

        $sql = self::$qb->getSQL();
        $params = self::$qb->getParameters();

        self::assertStringStartsWith('UPDATE ' . Module01Constants::TABLE_NAME, $sql);
        self::assertStringContainsString('id = :id, entity_type = :entity_type, date_created = :date_created, date_modified = :date_modified, deleted = :deleted', $sql);
        self::assertStringContainsString(', field01 = :field01', $sql);
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
            Entity01UpdateDAO::class => fn($container) => new class($container) extends Entity01UpdateDAO {

                use \Tests\TestDatabaseConnectionTrait;

                #[\Override]
                protected function updateRow(): void
                {
                    Entity01UpdateDAOTest::$qb = $this->createQuery();
                }
            },
        ];
    }
}
