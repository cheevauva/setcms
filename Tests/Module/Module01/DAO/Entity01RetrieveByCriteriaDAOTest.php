<?php

declare(strict_types=1);

namespace Tests\Module\Module01\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\UUID;
use SetCMS\Database\DatabaseQueryBuilder;
use Module\Module01\Module01Constants;
use Module\Module01\DAO\Entity01RetrieveByCriteriaDAO;
use Module\Module01\Exception\Entity01EntityNotFoundException;
use Module\Module01\Exception\Entity01EntitiesNotFoundException;
use Module\Module01\Exception\Entity01EntityExpectOneButReceivedTooMuchException;
use Module\Module01\Entity\Entity01Entity;

class Entity01RetrieveByCriteriaDAOTest extends \Tests\TestEasy
{

    use \Tests\Module\Module01\Entity01HelperTestTrait;

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

    public function testEntity01RetrieveByCriteriaDAOWithAllCriteria(): void
    {
        $id = new UUID();

        $retrieveByCriteria = Entity01RetrieveByCriteriaDAO::new(self::$container);
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

        self::assertStringContainsString('FROM ' . Module01Constants::TABLE_NAME, $sql);
        self::assertStringContainsString('id = :id', $sql);
        self::assertStringContainsString('LIMIT 1', $sql);
        self::assertStringContainsString('OFFSET 2', $sql);
        self::assertEquals([
            'id' => $id->uuid,
        ], $params);
    }

    public function testEntity01RetrieveByCriteriaDAOWithoutCriteria(): void
    {
        $id = new UUID();

        $retrieveByCriteria = Entity01RetrieveByCriteriaDAO::new(self::$container);
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
        self::$rows = [
            $this->prepareRow(),
            $this->prepareRow(),
        ];

        $findMany = Entity01RetrieveByCriteriaDAO::new(self::$container);
        $findMany->expectOne = false;
        $findMany->allowEmptyResult = true;
        $findMany->serve();

        self::assertNotEmpty($findMany->entities);
        self::assertCount(2, $findMany->entities);
        self::assertInstanceOf(Entity01Entity::class, $findMany->entities[0]);
        self::assertInstanceOf(Entity01Entity::class, $findMany->entities[1]);
    }

    public function testEntity01FindManyByCriteriaDAONotFound(): void
    {
        $findMany = Entity01RetrieveByCriteriaDAO::new(self::$container);
        $findMany->expectOne = false;
        $findMany->allowEmptyResult = true;
        $findMany->serve();

        self::assertEmpty($findMany->entities);
    }

    public function testEntity01FindOneByCriteriaDAOEmpty(): void
    {
        $findOne = Entity01RetrieveByCriteriaDAO::new(self::$container);
        $findOne->expectOne = true;
        $findOne->allowEmptyResult = true;
        $findOne->serve();

        self::assertEmpty($findOne->entity01OrNull);
    }

    public function testEntity01FindOneByCriteriaDAOFindOneRow(): void
    {
        self::$rows = [
            $this->prepareRow(),
        ];

        $findOne = Entity01RetrieveByCriteriaDAO::new(self::$container);
        $findOne->expectOne = true;
        $findOne->allowEmptyResult = true;
        $findOne->serve();

        self::assertNotEmpty($findOne->entity01);
        self::assertInstanceOf(Entity01Entity::class, $findOne->entity01);
    }

    public function testEntity01FindOneByCriteriaDAOFindTooMuchRows(): void
    {
        $this->expectException(Entity01EntityExpectOneButReceivedTooMuchException::class);

        self::$rows = [
            $this->prepareRow(),
            $this->prepareRow(),
        ];

        $findOne = Entity01RetrieveByCriteriaDAO::new(self::$container);
        $findOne->expectOne = true;
        $findOne->allowEmptyResult = true;
        $findOne->serve();
    }

    public function testEntity01GetOneByCriteriaDAONotFound(): void
    {
        $this->expectException(Entity01EntityNotFoundException::class);

        $getOne = Entity01RetrieveByCriteriaDAO::new(self::$container);
        $getOne->expectOne = true;
        $getOne->allowEmptyResult = false;
        $getOne->serve();
    }

    public function testEntity01GetManyByCriteriaDAONotFound(): void
    {
        $this->expectException(Entity01EntitiesNotFoundException::class);

        $getMany = Entity01RetrieveByCriteriaDAO::new(self::$container);
        $getMany->expectOne = false;
        $getMany->allowEmptyResult = false;
        $getMany->serve();
    }

    public function testEntity01GetManyByCriteriaDAOFoundRows(): void
    {
        self::$rows = [
            $this->prepareRow(),
            $this->prepareRow(),
        ];

        $getMany = Entity01RetrieveByCriteriaDAO::new(self::$container);
        $getMany->expectOne = false;
        $getMany->allowEmptyResult = false;
        $getMany->serve();

        self::assertNotEmpty($getMany->entities);
        self::assertCount(2, $getMany->entities);
        self::assertInstanceOf(Entity01Entity::class, $getMany->entities[0]);
        self::assertInstanceOf(Entity01Entity::class, $getMany->entities[1]);
    }

    public function testEntity01GetOneByCriteriaDAOFoundOneRow(): void
    {
        self::$rows = [
            $this->prepareRow(),
        ];

        $getOne = Entity01RetrieveByCriteriaDAO::new(self::$container);
        $getOne->expectOne = true;
        $getOne->allowEmptyResult = false;
        $getOne->serve();

        self::assertNotEmpty($getOne->entity01);
        self::assertInstanceOf(Entity01Entity::class, $getOne->entity01);
    }

    public function testEntity01GetOneByCriteriaDAOFoundTooMuchRows(): void
    {
        $this->expectException(Entity01EntityExpectOneButReceivedTooMuchException::class);

        self::$rows = [
            $this->prepareRow(),
            $this->prepareRow(),
        ];

        $getOne = Entity01RetrieveByCriteriaDAO::new(self::$container);
        $getOne->expectOne = true;
        $getOne->allowEmptyResult = false;
        $getOne->serve();
    }

    #[\Override]
    public function mocks(ContainerInterface $c): array
    {
        return [
            Entity01RetrieveByCriteriaDAO::class => fn() => new class($c) extends Entity01RetrieveByCriteriaDAO {

                use \Tests\TestDatabaseConnectionTrait;

                #[\Override]
                public function serve(): void
                {
                    Entity01RetrieveByCriteriaDAOTest::$qb = $this->createQb();

                    $this->checkRows(Entity01RetrieveByCriteriaDAOTest::$rows);
                    $this->handleRows(Entity01RetrieveByCriteriaDAOTest::$rows);
                }
            },
        ];
    }
}
