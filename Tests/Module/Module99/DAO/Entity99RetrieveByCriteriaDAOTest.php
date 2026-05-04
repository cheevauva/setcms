<?php

declare(strict_types=1);

namespace Tests\Module\Module99\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\Enum\SortEnum;
use SetCMS\UUID;
use SetCMS\Database\DatabaseQueryBuilder;
use Module\Module99\Module99Constants;
use Module\Module99\DAO\Entity99RetrieveByCriteriaDAO;
use Module\Module99\Exception\Entity99EntityNotFoundException;
use Module\Module99\Exception\Entity99EntitiesNotFoundException;
use Module\Module99\Exception\Entity99EntityExpectOneButReceivedTooMuchException;
use Module\Module99\Entity\Entity99Entity;

class Entity99RetrieveByCriteriaDAOTest extends \Tests\TestEasy
{

    use \Tests\Module\Module99\Entity99HelperTestTrait;

    public static ?DatabaseQueryBuilder $qb;

    /**
     * @var array<int, array<string, mixed>>
     */
    public static array $rows;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        
        self::$qb = null;
        self::$rows = [];
    }

    public function testEntity99RetrieveByCriteriaDAOWithAllCriteria(): void
    {
        $id = new UUID();

        $retrieveByCriteria = Entity99RetrieveByCriteriaDAO::new(self::$container);
        $retrieveByCriteria->entityType = Entity99Entity::class;
        $retrieveByCriteria->id = $id;
        $retrieveByCriteria->assignedBy = $id;
        $retrieveByCriteria->createdBy = $id;
        $retrieveByCriteria->modifiedBy = $id;
        $retrieveByCriteria->dateCreatedFrom = new \DateTimeImmutable('2020-02-02 01:01:01');
        $retrieveByCriteria->dateCreatedTo = new \DateTimeImmutable('2020-02-02 02:02:02');
        $retrieveByCriteria->dateModifiedFrom = new \DateTimeImmutable('2020-02-01 01:01:01');
        $retrieveByCriteria->dateModifiedTo = new \DateTimeImmutable('2020-02-01 02:02:02');
        $retrieveByCriteria->sortDateCreatedASC = true;
        $retrieveByCriteria->sortDateModifiedASC = true;
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

        self::assertStringContainsString('FROM ' . Module99Constants::TABLE_NAME . ' t', $sql);
        self::assertStringContainsString('deleted = :deleted', $sql);
        self::assertStringContainsString('id = :id', $sql);
        self::assertStringContainsString('created_by = :createdBy', $sql);
        self::assertStringContainsString('modified_by = :modifiedBy', $sql);
        self::assertStringContainsString('assigned_by = :assignedBy', $sql);
        self::assertStringContainsString('date_created >= :dateCreatedFrom', $sql);
        self::assertStringContainsString('date_created <= :dateCreatedTo', $sql);
        self::assertStringContainsString('date_modified >= :dateModifiedFrom', $sql);
        self::assertStringContainsString('date_modified <= :dateModifiedTo', $sql);
        self::assertStringContainsString('entity_type = :entityType', $sql);
        self::assertStringContainsString('date_created ASC', $sql);
        self::assertStringContainsString('date_modified ASC', $sql);
        self::assertStringContainsString('LIMIT 1', $sql);
        self::assertStringContainsString('OFFSET 2', $sql);
        self::assertEquals([
            'dateCreatedFrom' => '2020-02-02 01:01:01',
            'dateCreatedTo' => '2020-02-02 02:02:02',
            'dateModifiedFrom' => '2020-02-01 01:01:01',
            'dateModifiedTo' => '2020-02-01 02:02:02',
            'createdBy' => $id->uuid,
            'modifiedBy' => $id->uuid,
            'assignedBy' => $id->uuid,
            'id' => $id->uuid,
            'deleted' => 1,
            'entityType' => Entity99Entity::class,
        ], $params);
    }

    public function testEntity99RetrieveByCriteriaDAOWithoutCriteria(): void
    {
        $id = new UUID();

        $retrieveByCriteria = Entity99RetrieveByCriteriaDAO::new(self::$container);
        $retrieveByCriteria->serve();

        self::assertNotEmpty(self::$qb);

        if (empty(self::$qb)) {
            return;
        }

        $sql = self::$qb->getSQL();
        $params = self::$qb->getParameters();

        self::assertEquals('SELECT t.* FROM ' . Module99Constants::TABLE_NAME . ' t', $sql);
        self::assertEmpty($params);
    }

    public function testEntity99FindManyByCriteriaDAOFoundRows(): void
    {
        self::$rows = [
            $this->prepareRow(),
            $this->prepareRow(),
        ];

        $findMany = Entity99RetrieveByCriteriaDAO::new(self::$container);
        $findMany->expectOne = false;
        $findMany->allowEmptyResult = true;
        $findMany->serve();

        self::assertNotEmpty($findMany->entities);
        self::assertCount(2, $findMany->entities);
        self::assertInstanceOf(Entity99Entity::class, $findMany->entities[0]);
        self::assertInstanceOf(Entity99Entity::class, $findMany->entities[1]);
    }

    public function testEntity99FindManyByCriteriaDAONotFound(): void
    {
        $findMany = Entity99RetrieveByCriteriaDAO::new(self::$container);
        $findMany->expectOne = false;
        $findMany->allowEmptyResult = true;
        $findMany->serve();

        self::assertEmpty($findMany->entities);
    }

    public function testEntity99FindOneByCriteriaDAOEmpty(): void
    {
        $findOne = Entity99RetrieveByCriteriaDAO::new(self::$container);
        $findOne->expectOne = true;
        $findOne->allowEmptyResult = true;
        $findOne->serve();

        self::assertEmpty($findOne->entity99OrNull);
    }

    public function testEntity99FindOneByCriteriaDAOFindOneRow(): void
    {
        self::$rows = [
            $this->prepareRow(),
        ];

        $findOne = Entity99RetrieveByCriteriaDAO::new(self::$container);
        $findOne->expectOne = true;
        $findOne->allowEmptyResult = true;
        $findOne->serve();

        self::assertNotEmpty($findOne->entity99);
        self::assertInstanceOf(Entity99Entity::class, $findOne->entity99);
    }

    public function testEntity99FindOneByCriteriaDAOFindTooMuchRows(): void
    {
        $this->expectException(Entity99EntityExpectOneButReceivedTooMuchException::class);

        self::$rows = [
            $this->prepareRow(),
            $this->prepareRow(),
        ];

        $findOne = Entity99RetrieveByCriteriaDAO::new(self::$container);
        $findOne->expectOne = true;
        $findOne->allowEmptyResult = true;
        $findOne->serve();
    }

    public function testEntity99GetOneByCriteriaDAONotFound(): void
    {
        $this->expectException(Entity99EntityNotFoundException::class);

        $getOne = Entity99RetrieveByCriteriaDAO::new(self::$container);
        $getOne->expectOne = true;
        $getOne->allowEmptyResult = false;
        $getOne->serve();
    }

    public function testEntity99GetManyByCriteriaDAONotFound(): void
    {
        $this->expectException(Entity99EntitiesNotFoundException::class);

        $getMany = Entity99RetrieveByCriteriaDAO::new(self::$container);
        $getMany->expectOne = false;
        $getMany->allowEmptyResult = false;
        $getMany->serve();
    }

    public function testEntity99GetManyByCriteriaDAOFoundRows(): void
    {
        self::$rows = [
            $this->prepareRow(),
            $this->prepareRow(),
        ];

        $getMany = Entity99RetrieveByCriteriaDAO::new(self::$container);
        $getMany->expectOne = false;
        $getMany->allowEmptyResult = false;
        $getMany->serve();

        self::assertNotEmpty($getMany->entities);
        self::assertCount(2, $getMany->entities);
        self::assertInstanceOf(Entity99Entity::class, $getMany->entities[0]);
        self::assertInstanceOf(Entity99Entity::class, $getMany->entities[1]);
    }

    public function testEntity99GetOneByCriteriaDAOFoundOneRow(): void
    {
        self::$rows = [
            $this->prepareRow(),
        ];

        $getOne = Entity99RetrieveByCriteriaDAO::new(self::$container);
        $getOne->expectOne = true;
        $getOne->allowEmptyResult = false;
        $getOne->serve();

        self::assertNotEmpty($getOne->entity99);
        self::assertInstanceOf(Entity99Entity::class, $getOne->entity99);
    }

    public function testEntity99GetOneByCriteriaDAOFoundTooMuchRows(): void
    {
        $this->expectException(Entity99EntityExpectOneButReceivedTooMuchException::class);

        self::$rows = [
            $this->prepareRow(),
            $this->prepareRow(),
        ];

        $getOne = Entity99RetrieveByCriteriaDAO::new(self::$container);
        $getOne->expectOne = true;
        $getOne->allowEmptyResult = false;
        $getOne->serve();
    }

    #[\Override]
    public function mocks(ContainerInterface $c): array
    {
        return [
            Entity99RetrieveByCriteriaDAO::class => fn() => new class($c) extends Entity99RetrieveByCriteriaDAO {

                use \Tests\TestDatabaseConnectionTrait;

                #[\Override]
                public function serve(): void
                {
                    Entity99RetrieveByCriteriaDAOTest::$qb = $this->createQb();

                    $this->checkRows(Entity99RetrieveByCriteriaDAOTest::$rows);
                    $this->handleRows(Entity99RetrieveByCriteriaDAOTest::$rows);
                }
            },
        ];
    }
}
