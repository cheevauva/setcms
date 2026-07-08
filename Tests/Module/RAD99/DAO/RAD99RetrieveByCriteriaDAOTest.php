<?php

declare(strict_types=1);

namespace Tests\Module\RAD99\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\Enum\SortEnum;
use SetCMS\UUID;
use SetCMS\Database\DatabaseQueryBuilder;
use Module\RAD99\RAD99Constants;
use Module\RAD99\DAO\RAD99RetrieveByCriteriaDAO;
use Module\RAD99\Exception\RAD99EntityNotFoundException;
use Module\RAD99\Exception\RAD99EntitiesNotFoundException;
use Module\RAD99\Exception\RAD99EntityExpectOneButReceivedTooMuchException;
use Module\RAD99\Entity\RAD99Entity;

class RAD99RetrieveByCriteriaDAOTest extends \Tests\TestEasy
{

    use \Tests\Module\RAD99\RAD99HelperTestTrait;

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

    public function testRAD99RetrieveByCriteriaDAOWithAllCriteria(): void
    {
        $id = new UUID();

        $retrieveByCriteria = RAD99RetrieveByCriteriaDAO::new(self::$container);
        $retrieveByCriteria->entityType = RAD99Entity::class;
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

        self::assertStringContainsString('FROM ' . RAD99Constants::TABLE_NAME . ' t', $sql);
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
            'entityType' => RAD99Entity::class,
        ], $params);
    }

    public function testRAD99RetrieveByCriteriaDAOWithoutCriteria(): void
    {
        $id = new UUID();

        $retrieveByCriteria = RAD99RetrieveByCriteriaDAO::new(self::$container);
        $retrieveByCriteria->serve();

        self::assertNotEmpty(self::$qb);

        if (empty(self::$qb)) {
            return;
        }

        $sql = self::$qb->getSQL();
        $params = self::$qb->getParameters();

        self::assertEquals('SELECT t.* FROM ' . RAD99Constants::TABLE_NAME . ' t', $sql);
        self::assertEmpty($params);
    }

    public function testRAD99FindManyByCriteriaDAOFoundRows(): void
    {
        self::$rows = [
            $this->prepareRow(),
            $this->prepareRow(),
        ];

        $findMany = RAD99RetrieveByCriteriaDAO::new(self::$container);
        $findMany->expectOne = false;
        $findMany->allowEmptyResult = true;
        $findMany->serve();

        self::assertNotEmpty($findMany->rad99s);
        self::assertCount(2, $findMany->rad99s);
        self::assertInstanceOf(RAD99Entity::class, $findMany->rad99s[0]);
        self::assertInstanceOf(RAD99Entity::class, $findMany->rad99s[1]);
    }

    public function testRAD99FindManyByCriteriaDAONotFound(): void
    {
        $findMany = RAD99RetrieveByCriteriaDAO::new(self::$container);
        $findMany->expectOne = false;
        $findMany->allowEmptyResult = true;
        $findMany->serve();

        self::assertEmpty($findMany->rad99s);
    }

    public function testRAD99FindOneByCriteriaDAOEmpty(): void
    {
        $findOne = RAD99RetrieveByCriteriaDAO::new(self::$container);
        $findOne->expectOne = true;
        $findOne->allowEmptyResult = true;
        $findOne->serve();

        self::assertEmpty($findOne->rad99OrNull);
    }

    public function testRAD99FindOneByCriteriaDAOFindOneRow(): void
    {
        self::$rows = [
            $this->prepareRow(),
        ];

        $findOne = RAD99RetrieveByCriteriaDAO::new(self::$container);
        $findOne->expectOne = true;
        $findOne->allowEmptyResult = true;
        $findOne->serve();

        self::assertNotEmpty($findOne->rad99);
        self::assertInstanceOf(RAD99Entity::class, $findOne->rad99);
    }

    public function testRAD99FindOneByCriteriaDAOFindTooMuchRows(): void
    {
        $this->expectException(RAD99EntityExpectOneButReceivedTooMuchException::class);

        self::$rows = [
            $this->prepareRow(),
            $this->prepareRow(),
        ];

        $findOne = RAD99RetrieveByCriteriaDAO::new(self::$container);
        $findOne->expectOne = true;
        $findOne->allowEmptyResult = true;
        $findOne->serve();
    }

    public function testRAD99GetOneByCriteriaDAONotFound(): void
    {
        $this->expectException(RAD99EntityNotFoundException::class);

        $getOne = RAD99RetrieveByCriteriaDAO::new(self::$container);
        $getOne->expectOne = true;
        $getOne->allowEmptyResult = false;
        $getOne->serve();
    }

    public function testRAD99GetManyByCriteriaDAONotFound(): void
    {
        $this->expectException(RAD99EntitiesNotFoundException::class);

        $getMany = RAD99RetrieveByCriteriaDAO::new(self::$container);
        $getMany->expectOne = false;
        $getMany->allowEmptyResult = false;
        $getMany->serve();
    }

    public function testRAD99GetManyByCriteriaDAOFoundRows(): void
    {
        self::$rows = [
            $this->prepareRow(),
            $this->prepareRow(),
        ];

        $getMany = RAD99RetrieveByCriteriaDAO::new(self::$container);
        $getMany->expectOne = false;
        $getMany->allowEmptyResult = false;
        $getMany->serve();

        self::assertNotEmpty($getMany->rad99s);
        self::assertCount(2, $getMany->rad99s);
        self::assertInstanceOf(RAD99Entity::class, $getMany->rad99s[0]);
        self::assertInstanceOf(RAD99Entity::class, $getMany->rad99s[1]);
    }

    public function testRAD99GetOneByCriteriaDAOFoundOneRow(): void
    {
        self::$rows = [
            $this->prepareRow(),
        ];

        $getOne = RAD99RetrieveByCriteriaDAO::new(self::$container);
        $getOne->expectOne = true;
        $getOne->allowEmptyResult = false;
        $getOne->serve();

        self::assertNotEmpty($getOne->rad99);
        self::assertInstanceOf(RAD99Entity::class, $getOne->rad99);
    }

    public function testRAD99GetOneByCriteriaDAOFoundTooMuchRows(): void
    {
        $this->expectException(RAD99EntityExpectOneButReceivedTooMuchException::class);

        self::$rows = [
            $this->prepareRow(),
            $this->prepareRow(),
        ];

        $getOne = RAD99RetrieveByCriteriaDAO::new(self::$container);
        $getOne->expectOne = true;
        $getOne->allowEmptyResult = false;
        $getOne->serve();
    }

    #[\Override]
    public function mocks(ContainerInterface $c): array
    {
        return [
            RAD99RetrieveByCriteriaDAO::class => fn() => new class($c) extends RAD99RetrieveByCriteriaDAO {

                use \Tests\TestDatabaseConnectionTrait;

                #[\Override]
                public function serve(): void
                {
                    RAD99RetrieveByCriteriaDAOTest::$qb = $this->createQb();

                    $this->checkRows(RAD99RetrieveByCriteriaDAOTest::$rows);
                    $this->handleRows(RAD99RetrieveByCriteriaDAOTest::$rows);
                }
            },
        ];
    }
}
