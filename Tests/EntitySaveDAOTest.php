<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use SetCMS\Common\DAO\EntitySaveDAO;
use SetCMS\Common\Mapper\EntityMapper;
use SetCMS\Common\Entity\Entity;
use Psr\Container\ContainerInterface;

class EntitySaveDAOTest extends TestCase
{

    use TestTrait;

    /**
     * @var array<string, mixed>
     */
    public static array $results = [];
    public static Entity $entity;

    protected function newEntity(): Entity
    {
        $entity = new Entity;

        return $entity;
    }

    public function testQueries(): void
    {
        $entity = self::$entity = $this->newEntity();

        $save = EntitySaveDAO::new($this->container($this->mocks()));
        $save->serve();

        $this->assertEquals('SELECT id FROM tests WHERE id = :id LIMIT 1', self::$results['has'][0]);
        $this->assertEquals($entity->id, self::$results['has'][1]['id']);

        $this->assertEquals('UPDATE tests SET id = :id, entity_type = :entity_type, date_created = :date_created, date_modified = :date_modified, deleted = :deleted WHERE id = :id', self::$results['update'][0]);
        $this->assertEquals($entity->id, self::$results['update'][1]['id']);
        $this->assertEquals($entity->entityType, self::$results['update'][1]['entity_type']);
        $this->assertEquals($entity->dateCreated->format('Y-m-d H:i:s'), self::$results['update'][1]['date_created']);
        $this->assertEquals($entity->dateModified->format('Y-m-d H:i:s'), self::$results['update'][1]['date_modified']);
        $this->assertEquals(intval($entity->deleted), self::$results['update'][1]['deleted']);

        $this->assertEquals('INSERT INTO tests (id, entity_type, date_created, date_modified, deleted) VALUES(:id, :entity_type, :date_created, :date_modified, :deleted)', self::$results['insert'][0]);
        $this->assertEquals($entity->id, self::$results['insert'][1]['id']);
        $this->assertEquals($entity->entityType, self::$results['insert'][1]['entity_type']);
        $this->assertEquals($entity->dateCreated->format('Y-m-d H:i:s'), self::$results['insert'][1]['date_created']);
        $this->assertEquals($entity->dateModified->format('Y-m-d H:i:s'), self::$results['insert'][1]['date_modified']);
        $this->assertEquals(intval($entity->deleted), self::$results['insert'][1]['deleted']);
    }

    /**
     * @return \Closure
     */
    protected function mocks(): \Closure
    {
        return fn(ContainerInterface $container) => [
            EntityMapper::class => fn($container) => new class($container) extends EntityMapper {
                
            },
            EntitySaveDAO::class => fn($container) => new class($container) extends EntitySaveDAO {

                use \UUA\Traits\ContainerTrait;
                use TestDatabaseConnectionTrait;

                public Entity $testEntity;

                #[\Override]
                protected function mapper(): EntityMapper
                {
                    return EntityMapper::new($this->container);
                }

                #[\Override]
                protected function table(): string
                {
                    return 'tests';
                }

                #[\Override]
                public function serve(): void
                {
                    $this->entity = EntitySaveDAOTest::$entity;

                    EntitySaveDAOTest::$results['has'] = [$this->has()->getSQL(), $this->has()->getParameters()];
                    EntitySaveDAOTest::$results['insert'] = [$this->insert()->getSQL(), $this->insert()->getParameters()];
                    EntitySaveDAOTest::$results['update'] = [$this->update()->getSQL(), $this->update()->getParameters()];
                }
            },
        ];
    }
}
