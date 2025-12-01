<?php

declare(strict_types=1);

namespace Tests\Module\Module01\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\Enum\SortEnum;
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
    use \Tests\Module\Module01\Entity01HelperTestTrait;

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

    public function testEntity01RetrieveByCriteriaDAOWithAllCriteria(): void
    {
        $id = new UUID();

        $retrieveByCriteria = Entity01RetrieveByCriteriaDAO::new($this->container($this->mocks()));
        $retrieveByCriteria->entityType = 'test';
        $retrieveByCriteria->id = $id;
        $retrieveByCriteria->assignedBy = $id;
        $retrieveByCriteria->createdBy = $id;
        $retrieveByCriteria->modifiedBy = $id;
        $retrieveByCriteria->dateCreatedFrom = new \DateTimeImmutable('2020-02-02 01:01:01');
        $retrieveByCriteria->dateCreatedTo = new \DateTimeImmutable('2020-02-02 02:02:02');
        $retrieveByCriteria->dateModifiedFrom = new \DateTimeImmutable('2020-02-01 01:01:01');
        $retrieveByCriteria->dateModifiedTo = new \DateTimeImmutable('2020-02-01 02:02:02');
        $retrieveByCriteria->sortByDateCreated = SortEnum::ASC;
        $retrieveByCriteria->sortByDateModified = SortEnum::ASC;
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
        self::assertStringContainsString('created_by = :created_by', $sql);
        self::assertStringContainsString('modified_by = :modified_by', $sql);
        self::assertStringContainsString('assigned_by = :assigned_by', $sql);
        self::assertStringContainsString('date_created >= :dateCreatedFrom', $sql);
        self::assertStringContainsString('date_created <= :dateCreatedTo', $sql);
        self::assertStringContainsString('date_modified >= :dateModifiedFrom', $sql);
        self::assertStringContainsString('date_modified <= :dateModifiedTo', $sql);
        self::assertStringContainsString('entity_type = :entity_type', $sql);
        self::assertStringContainsString('date_created ASC', $sql);
        self::assertStringContainsString('date_modified ASC', $sql);
        self::assertStringContainsString('LIMIT 1', $sql);
        self::assertStringContainsString('OFFSET 2', $sql);
        self::assertEquals([
            'dateCreatedFrom' => '2020-02-02 01:01:01',
            'dateCreatedTo' => '2020-02-02 02:02:02',
            'dateModifiedFrom' => '2020-02-01 01:01:01',
            'dateModifiedTo' => '2020-02-01 02:02:02',
            'created_by' => $id->uuid,
            'modified_by' => $id->uuid,
            'assigned_by' => $id->uuid,
            'id' => $id->uuid,
            'deleted' => 1,
            'entity_type' => 'test',
        ], $params);
    }

    public function testEntity01RetrieveByCriteriaDAOWithoutCriteria(): void
    {
        $id = new UUID();

        $retrieveByCriteria = Entity01RetrieveByCriteriaDAO::new($this->container($this->mocks()));
        $retrieveByCriteria->serve();

        self::assertNotEmpty(self::$qb);

        if (empty(self::$qb)) {
            return;
        }

        $sql = self::$qb->getSQL();
        $params = self::$qb->getParameters();

        self::assertEquals('SELECT * FROM ' . Module01Constants::TABLE_NAME, $sql);
        self::assertEmpty($params);
    }

    public function testEntity01FindManyByCriteriaDAOFoundRows(): void
    {
        self::$findManyRows = [
            $this->prepareRow(),
            $this->prepareRow(),
        ];

        $findMany = Entity01FindManyByCriteriaDAO::new($this->container($this->mocks()));
        $findMany->serve();

        self::assertNotEmpty($findMany->entities);
        self::assertCount(2, $findMany->entities);
        self::assertInstanceOf(Entity01Entity::class, $findMany->entities[0]);
        self::assertInstanceOf(Entity01Entity::class, $findMany->entities[1]);
    }

    public function testEntity01FindManyByCriteriaDAONotFound(): void
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

                #[\Override]
                protected function handleRows(array $rows): void
                {
                    ;
                }
            },
            Entity01FindManyByCriteriaDAO::class => fn($container) => new class($container) extends Entity01FindManyByCriteriaDAO {

                use \Tests\TestDatabaseConnectionTrait;

                /**
                 * @return array<int, array<string, mixed>>
                 */
                #[\Override]
                protected function retrieveRows(): array
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
                protected function retrieveRows(): array
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
                protected function retrieveRows(): array
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
                protected function retrieveRows(): array
                {
                    Entity01RetrieveByCriteriaDAOTest::$qb = $this->createQuery();

                    return Entity01RetrieveByCriteriaDAOTest::$getManyRows;
                }
            },
        ];
    }
}
