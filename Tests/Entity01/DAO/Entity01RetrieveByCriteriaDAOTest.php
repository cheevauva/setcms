<?php

declare(strict_types=1);

namespace Tests\Entity01\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\UUID;
use SetCMS\Database\DatabaseQueryBuilder;
use Module\Module01\Module01Constants;
use Module\Module01\DAO\Entity01FindManyByCriteriaDAO;
use Module\Module01\DAO\Entity01FindOneByCriteriaDAO;
use Module\Module01\DAO\Entity01GetManyByCriteriaDAO;
use Module\Module01\DAO\Entity01GetOneByCriteriaDAO;
use Module\Module01\DAO\Entity01RetrieveByCriteriaDAO;
use Module\Module01\Exception\Entity01EntityNotFoundException;
use Module\Module01\Exception\Entity01EntitiesNotFoundException;
use Module\Module01\Exception\Entity01EntityExpectOneButReceivedTooMuchException;
use Module\Module01\Entity\Entity01Entity;

class Entity01RetrieveByCriteriaDAOTest extends \PHPUnit\Framework\TestCase
{

    use \Tests\TestTrait;

    public static ?DatabaseQueryBuilder $qb;

    /**
     * @var array<int, array<string, mixed>>
     */
    public static array $findManyRows;

    /**
     * @var array<int, array<string, mixed>>
     */
    public static array $findOneRows;

    /**
     * @var array<int, array<string, mixed>>
     */
    public static array $getOneRows;

    /**
     * @var array<int, array<string, mixed>>
     */
    public static array $getManyRows;

    #[\Override]
    protected function setUp(): void
    {
        self::$qb = null;
        self::$findManyRows = [];
        self::$findOneRows = [];
        self::$getOneRows = [];
        self::$getManyRows = [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function prepareRow(): array
    {
        return [
            'id' => (new UUID)->uuid,
            'entity_type' => 'entity01lc',
            'date_created' => '2020-02-02 02:02:02',
            'date_modified' => '2020-02-02 02:02:02',
            'deleted' => 0,
            'field01' => 'field01',
        ];
    }

    public function testEntity01RetrieveByCriteriaDAO(): void
    {
        $id = new UUID();

        $retrieveByCriteria = Entity01RetrieveByCriteriaDAO::new($this->container($this->mocks()));
        $retrieveByCriteria->id = $id;
        $retrieveByCriteria->deleted = true;
        $retrieveByCriteria->limit = 1;
        $retrieveByCriteria->offset = 2;
        $retrieveByCriteria->serve();

        self::assertNotEmpty(self::$qb);

        if (empty(self::$qb)) {
            return;
        }

        $sql = self::$qb->getSQL();
        $params = self::$qb->getParameters();

        self::assertStringContainsString('FROM ' . Module01Constants::TABLE_NAME, $sql);
        self::assertStringContainsString('deleted = :deleted', $sql);
        self::assertStringContainsString('id = :id', $sql);
        self::assertStringContainsString('LIMIT 1', $sql);
        self::assertStringContainsString('OFFSET 2', $sql);
        self::assertEquals([
            'id' => $id->uuid,
            'deleted' => 1,
        ], $params);
    }

    public function testEntity01FindManyByCriteriaDAOEmpty(): void
    {
        $findMany = Entity01FindManyByCriteriaDAO::new($this->container($this->mocks()));
        $findMany->serve();

        self::assertEmpty($findMany->entities);
    }

    public function testEntity01FindOneByCriteriaDAOEmpty(): void
    {
        $findOne = Entity01FindOneByCriteriaDAO::new($this->container($this->mocks()));
        $findOne->serve();

        self::assertEmpty($findOne->entity);
    }

    public function testEntity01FindOneByCriteriaDAOFindOneRow(): void
    {
        self::$findOneRows = [
            $this->prepareRow(),
        ];

        $findOne = Entity01FindOneByCriteriaDAO::new($this->container($this->mocks()));
        $findOne->serve();

        self::assertNotEmpty($findOne->entity);
        self::assertInstanceOf(Entity01Entity::class, $findOne->entity);
    }

    public function testEntity01FindOneByCriteriaDAOFindTooMuchRows(): void
    {
        $this->expectException(Entity01EntityExpectOneButReceivedTooMuchException::class);

        self::$findOneRows = [
            $this->prepareRow(),
            $this->prepareRow(),
        ];

        $findOne = Entity01FindOneByCriteriaDAO::new($this->container($this->mocks()));
        $findOne->serve();
    }

    public function testEntity01GetOneByCriteriaDAONotFound(): void
    {
        $this->expectException(Entity01EntityNotFoundException::class);

        $getOne = Entity01GetOneByCriteriaDAO::new($this->container($this->mocks()));
        $getOne->serve();
    }

    public function testEntity01GetManyByCriteriaDAONotFound(): void
    {
        $this->expectException(Entity01EntitiesNotFoundException::class);

        $getMany = Entity01GetManyByCriteriaDAO::new($this->container($this->mocks()));
        $getMany->serve();
    }

    public function testEntity01GetManyByCriteriaDAOFoundRows(): void
    {
        self::$getManyRows = [
            $this->prepareRow(),
            $this->prepareRow(),
        ];

        $getMany = Entity01GetManyByCriteriaDAO::new($this->container($this->mocks()));
        $getMany->serve();

        self::assertNotEmpty($getMany->entities);
        self::assertCount(2, $getMany->entities);
        self::assertInstanceOf(Entity01Entity::class, $getMany->entities[0]);
        self::assertInstanceOf(Entity01Entity::class, $getMany->entities[1]);
    }

    public function testEntity01GetOneByCriteriaDAOFoundOneRow(): void
    {
        self::$getOneRows = [
            $this->prepareRow(),
        ];

        $getOne = Entity01GetOneByCriteriaDAO::new($this->container($this->mocks()));
        $getOne->serve();

        self::assertNotEmpty($getOne->entity);
        self::assertInstanceOf(Entity01Entity::class, $getOne->entity);
    }

    public function testEntity01GetOneByCriteriaDAOFoundTooMuchRows(): void
    {
        $this->expectException(Entity01EntityExpectOneButReceivedTooMuchException::class);

        self::$getOneRows = [
            $this->prepareRow(),
            $this->prepareRow(),
        ];

        $getOne = Entity01GetOneByCriteriaDAO::new($this->container($this->mocks()));
        $getOne->serve();
    }

    public function mocks(): \Closure
    {
        return fn(ContainerInterface $container) => [
            'entities' => [
                'entity01lc' => Entity01Entity::class,
            ],
            Entity01RetrieveByCriteriaDAO::class => fn($container) => new class($container) extends Entity01RetrieveByCriteriaDAO {

                use \Tests\TestDatabaseConnectionTrait;

                #[\Override]
                public function serve(): void
                {
                    Entity01RetrieveByCriteriaDAOTest::$qb = $this->createQuery();
                }
            },
            Entity01FindManyByCriteriaDAO::class => fn($container) => new class($container) extends Entity01FindManyByCriteriaDAO {

                use \Tests\TestDatabaseConnectionTrait;

                /**
                 * @return array<int, array<string, mixed>>
                 */
                #[\Override]
                protected function retrieveAll(): array
                {
                    Entity01RetrieveByCriteriaDAOTest::$qb = $this->createQuery();

                    return Entity01RetrieveByCriteriaDAOTest::$findManyRows;
                }
            },
            Entity01FindOneByCriteriaDAO::class => fn($container) => new class($container) extends Entity01FindOneByCriteriaDAO {

                use \Tests\TestDatabaseConnectionTrait;

                /**
                 * @return array<int, array<string, mixed>>
                 */
                #[\Override]
                protected function retrieveAll(): array
                {
                    Entity01RetrieveByCriteriaDAOTest::$qb = $this->createQuery();

                    return Entity01RetrieveByCriteriaDAOTest::$findOneRows;
                }
            },
            Entity01GetOneByCriteriaDAO::class => fn($container) => new class($container) extends Entity01GetOneByCriteriaDAO {

                use \Tests\TestDatabaseConnectionTrait;

                /**
                 * @return array<int, array<string, mixed>>
                 */
                #[\Override]
                protected function retrieveAll(): array
                {
                    Entity01RetrieveByCriteriaDAOTest::$qb = $this->createQuery();

                    return Entity01RetrieveByCriteriaDAOTest::$getOneRows;
                }
            },
            Entity01GetManyByCriteriaDAO::class => fn($container) => new class($container) extends Entity01GetManyByCriteriaDAO {

                use \Tests\TestDatabaseConnectionTrait;

                /**
                 * @return array<int, array<string, mixed>>
                 */
                #[\Override]
                protected function retrieveAll(): array
                {
                    Entity01RetrieveByCriteriaDAOTest::$qb = $this->createQuery();

                    return Entity01RetrieveByCriteriaDAOTest::$getManyRows;
                }
            },
        ];
    }
}
