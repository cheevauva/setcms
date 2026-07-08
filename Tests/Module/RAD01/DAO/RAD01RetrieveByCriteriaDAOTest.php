<?php

declare(strict_types=1);

namespace Tests\Module\RAD01\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\UUID;
use SetCMS\Database\DatabaseQueryBuilder;
use Module\RAD01\RAD01Constants;
use Module\RAD01\DAO\RAD01RetrieveByCriteriaDAO;
use Module\RAD01\Exception\RAD01EntityNotFoundException;
use Module\RAD01\Exception\RAD01EntitiesNotFoundException;
use Module\RAD01\Exception\RAD01EntityExpectOneButReceivedTooMuchException;
use Module\RAD01\Entity\RAD01Entity;

class RAD01RetrieveByCriteriaDAOTest extends \Tests\TestEasy
{

    use \Tests\Module\RAD01\RAD01HelperTestTrait;

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

    public function testRAD01RetrieveByCriteriaDAOWithAllCriteria(): void
    {
        $id = new UUID();

        $retrieveByCriteria = RAD01RetrieveByCriteriaDAO::new(self::$container);
        $retrieveByCriteria->id = $id;
        $retrieveByCriteria->limit = 1;
        $retrieveByCriteria->offset = 2;
        $retrieveByCriteria->serve();

        self::assertNotEmpty(self::$qb);

        if (empty(self::$qb)) {
            return;
        }

        $sql = self::$qb->getSQL();
        $params = self::$qb->getParameters();

        self::assertStringContainsString('FROM ' . RAD01Constants::TABLE_NAME . ' t', $sql);
        self::assertStringContainsString('id = :id', $sql);
        self::assertStringContainsString('LIMIT 1', $sql);
        self::assertStringContainsString('OFFSET 2', $sql);
        self::assertEquals([
            'id' => $id->uuid,
        ], $params);
    }

    public function testRAD01RetrieveByCriteriaDAOWithoutCriteria(): void
    {
        $id = new UUID();

        $retrieveByCriteria = RAD01RetrieveByCriteriaDAO::new(self::$container);
        $retrieveByCriteria->serve();

        self::assertNotEmpty(self::$qb);

        if (empty(self::$qb)) {
            return;
        }

        $sql = self::$qb->getSQL();
        $params = self::$qb->getParameters();

        self::assertEquals('SELECT t.* FROM ' . RAD01Constants::TABLE_NAME . ' t', $sql);
        self::assertEmpty($params);
    }

    public function testRAD01FindManyByCriteriaDAOFoundRows(): void
    {
        self::$rows = [
            $this->prepareRow(),
            $this->prepareRow(),
        ];

        $findMany = RAD01RetrieveByCriteriaDAO::new(self::$container);
        $findMany->expectOne = false;
        $findMany->allowEmptyResult = true;
        $findMany->serve();

        self::assertNotEmpty($findMany->rad01s);
        self::assertCount(2, $findMany->rad01s);
        self::assertInstanceOf(RAD01Entity::class, $findMany->rad01s[0]);
        self::assertInstanceOf(RAD01Entity::class, $findMany->rad01s[1]);
    }

    public function testRAD01FindManyByCriteriaDAONotFound(): void
    {
        $findMany = RAD01RetrieveByCriteriaDAO::new(self::$container);
        $findMany->expectOne = false;
        $findMany->allowEmptyResult = true;
        $findMany->serve();

        self::assertEmpty($findMany->rad01s);
    }

    public function testRAD01FindOneByCriteriaDAOEmpty(): void
    {
        $findOne = RAD01RetrieveByCriteriaDAO::new(self::$container);
        $findOne->expectOne = true;
        $findOne->allowEmptyResult = true;
        $findOne->serve();

        self::assertEmpty($findOne->rad01OrNull);
    }

    public function testRAD01FindOneByCriteriaDAOFindOneRow(): void
    {
        self::$rows = [
            $this->prepareRow(),
        ];

        $findOne = RAD01RetrieveByCriteriaDAO::new(self::$container);
        $findOne->expectOne = true;
        $findOne->allowEmptyResult = true;
        $findOne->serve();

        self::assertNotEmpty($findOne->rad01);
        self::assertInstanceOf(RAD01Entity::class, $findOne->rad01);
    }

    public function testRAD01FindOneByCriteriaDAOFindTooMuchRows(): void
    {
        $this->expectException(RAD01EntityExpectOneButReceivedTooMuchException::class);

        self::$rows = [
            $this->prepareRow(),
            $this->prepareRow(),
        ];

        $findOne = RAD01RetrieveByCriteriaDAO::new(self::$container);
        $findOne->expectOne = true;
        $findOne->allowEmptyResult = true;
        $findOne->serve();
    }

    public function testRAD01GetOneByCriteriaDAONotFound(): void
    {
        $this->expectException(RAD01EntityNotFoundException::class);

        $getOne = RAD01RetrieveByCriteriaDAO::new(self::$container);
        $getOne->expectOne = true;
        $getOne->allowEmptyResult = false;
        $getOne->serve();
    }

    public function testRAD01GetManyByCriteriaDAONotFound(): void
    {
        $this->expectException(RAD01EntitiesNotFoundException::class);

        $getMany = RAD01RetrieveByCriteriaDAO::new(self::$container);
        $getMany->expectOne = false;
        $getMany->allowEmptyResult = false;
        $getMany->serve();
    }

    public function testRAD01GetManyByCriteriaDAOFoundRows(): void
    {
        self::$rows = [
            $this->prepareRow(),
            $this->prepareRow(),
        ];

        $getMany = RAD01RetrieveByCriteriaDAO::new(self::$container);
        $getMany->expectOne = false;
        $getMany->allowEmptyResult = false;
        $getMany->serve();

        self::assertNotEmpty($getMany->rad01s);
        self::assertCount(2, $getMany->rad01s);
        self::assertInstanceOf(RAD01Entity::class, $getMany->rad01s[0]);
        self::assertInstanceOf(RAD01Entity::class, $getMany->rad01s[1]);
    }

    public function testRAD01GetOneByCriteriaDAOFoundOneRow(): void
    {
        self::$rows = [
            $this->prepareRow(),
        ];

        $getOne = RAD01RetrieveByCriteriaDAO::new(self::$container);
        $getOne->expectOne = true;
        $getOne->allowEmptyResult = false;
        $getOne->serve();

        self::assertNotEmpty($getOne->rad01);
        self::assertInstanceOf(RAD01Entity::class, $getOne->rad01);
    }

    public function testRAD01GetOneByCriteriaDAOFoundTooMuchRows(): void
    {
        $this->expectException(RAD01EntityExpectOneButReceivedTooMuchException::class);

        self::$rows = [
            $this->prepareRow(),
            $this->prepareRow(),
        ];

        $getOne = RAD01RetrieveByCriteriaDAO::new(self::$container);
        $getOne->expectOne = true;
        $getOne->allowEmptyResult = false;
        $getOne->serve();
    }

    #[\Override]
    public function mocks(ContainerInterface $c): array
    {
        return [
            RAD01RetrieveByCriteriaDAO::class => fn() => new class($c) extends RAD01RetrieveByCriteriaDAO {

                use \Tests\TestDatabaseConnectionTrait;

                #[\Override]
                public function serve(): void
                {
                    RAD01RetrieveByCriteriaDAOTest::$qb = $this->createQb();

                    $this->checkRows(RAD01RetrieveByCriteriaDAOTest::$rows);
                    $this->handleRows(RAD01RetrieveByCriteriaDAOTest::$rows);
                }
            },
        ];
    }
}
