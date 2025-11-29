<?php

declare(strict_types=1);

namespace Tests\Module\Module01\DAO;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use SetCMS\UUID;
use SetCMS\Database\DatabaseQueryBuilder;
use Module\Module01\Module01Constants;
use Module\Module01\DAO\Entity01UpdateDAO;
use Module\Module01\Entity\Entity01Entity;

class Entity01UpdateDAOTest extends TestCase
{

    use \Tests\TestTrait;

    public static ?DatabaseQueryBuilder $qb = null;

    #[\Override]
    protected function setUp(): void
    {
        self::$qb = null;
    }

    public function testEntity01UpdateDAO(): void
    {
        $entity = new Entity01Entity;
        $entity->id = new UUID('331c1832-d5e1-43a6-aef0-6fa6ffbe01a6');
        $entity->dateCreated = new \DateTimeImmutable('2025-11-29 19:56:10');
        $entity->dateModified = new \DateTimeImmutable('2025-11-29 19:56:10');
        $entity->deleted = false;
        $entity->field01 = 'field01';

        $create = Entity01UpdateDAO::new($this->container($this->mocks()));
        $create->entity = $entity;
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
        self::assertEquals([
            'id' => '331c1832-d5e1-43a6-aef0-6fa6ffbe01a6',
            'entity_type' => 'entity01lc',
            'date_created' => '2025-11-29 19:56:10',
            'date_modified' => '2025-11-29 19:56:10',
            'deleted' => 0,
            'field01' => 'field01',
        ], $params);
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
