<?php

declare(strict_types=1);

namespace Tests\Module\Module01\DAO;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use SetCMS\UUID;
use SetCMS\Database\DatabaseQueryBuilder;
use Module\Module01\Module01Constants;
use Module\Module01\DAO\Entity01CreateDAO;
use Module\Module01\Entity\Entity01Entity;

class Entity01CreateDAOTest extends TestCase
{

    use \Tests\TestTrait;

    /**
     * @var array<string, mixed>
     */
    public static array $results = [];
    public static Entity01Entity $entity;
    public static ?DatabaseQueryBuilder $qb = null;

    #[\Override]
    protected function setUp(): void
    {
        self::$qb = null;
    }

    protected function newEntity(): Entity01Entity
    {
        $entity = new Entity01Entity;
        $entity->id = new UUID('331c1832-d5e1-43a6-aef0-6fa6ffbe01a6');
        $entity->dateCreated = new \DateTimeImmutable('2025-11-29 19:56:10');
        $entity->dateModified = new \DateTimeImmutable('2025-11-29 19:56:10');
        $entity->deleted = false;
        $entity->field01 = 'field01';

        return $entity;
    }

    public function testQueries(): void
    {
        $entity = self::$entity = $this->newEntity();

        $create = Entity01CreateDAO::new($this->container($this->mocks()));
        $create->entity = $entity;
        $create->serve();

        self::assertNotEmpty(self::$qb);

        if (empty(self::$qb)) {
            return;
        }

        $sql = self::$qb->getSQL();
        $params = self::$qb->getParameters();

        self::assertStringStartsWith('INSERT INTO ' . Module01Constants::TABLE_NAME, $sql);
        self::assertStringContainsString('id, entity_type, date_created, date_modified, deleted', $sql);
        self::assertStringContainsString(':id, :entity_type, :date_created, :date_modified, :deleted', $sql);
        self::assertStringContainsString(', field01', $sql);
        self::assertStringContainsString(', :field01', $sql);
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
            Entity01CreateDAO::class => fn($container) => new class($container) extends Entity01CreateDAO {

                use \Tests\TestDatabaseConnectionTrait;

                #[\Override]
                protected function insert(): void
                {
                    Entity01CreateDAOTest::$qb = parent::createQuery();
                }
            },
        ];
    }
}
