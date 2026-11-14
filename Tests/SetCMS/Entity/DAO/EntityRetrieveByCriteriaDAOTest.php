<?php

declare(strict_types=1);

namespace Tests\SetCMS\Entity\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\Entity\Entity;
use SetCMS\Database\DatabaseQueryBuilder;
use SetCMS\Entity\DAO\EntityRetrieveByCriteriaDAO;
use SetCMS\Entity\Exception\EntityExpectOneButReceivedTooMuchException;
use SetCMS\Entity\Exception\EntityNotFoundException;
use SetCMS\Entity\Exception\EntitiesNotFoundException;

class EntityRetrieveByCriteriaDAOTest extends \Tests\TestEasy
{   
    public static array $rows;
    
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        
        self::$rows = [];
    }

    public function testFindManyByCriteriaDAOFoundRows(): void
    {
        self::$rows = [
            $this->prepareRow(),
            $this->prepareRow(),
        ];

        $findMany = EntityRetrieveByCriteriaDAO::new(self::$container);
        $findMany->expectOne = false;
        $findMany->allowEmptyResult = true;
        $findMany->serve();

        self::assertNotEmpty($findMany->entities);
        self::assertCount(2, $findMany->entities);
        self::assertInstanceOf(Entity::class, $findMany->entities[0]);
        self::assertInstanceOf(Entity::class, $findMany->entities[1]);
    }

    public function testFindManyByCriteriaDAONotFound(): void
    {
        $findMany = EntityRetrieveByCriteriaDAO::new(self::$container);
        $findMany->expectOne = false;
        $findMany->allowEmptyResult = true;
        $findMany->serve();

        self::assertEmpty($findMany->entities);
    }

    public function testFindOneByCriteriaDAOEmpty(): void
    {
        $findOne = EntityRetrieveByCriteriaDAO::new(self::$container);
        $findOne->expectOne = true;
        $findOne->allowEmptyResult = true;
        $findOne->serve();

        self::assertEmpty($findOne->entityOrNull);
    }

    public function testFindOneByCriteriaDAOFindOneRow(): void
    {
        self::$rows = [
            $this->prepareRow(),
        ];

        $findOne = EntityRetrieveByCriteriaDAO::new(self::$container);
        $findOne->expectOne = true;
        $findOne->allowEmptyResult = true;
        $findOne->serve();

        self::assertNotEmpty($findOne->entity);
        self::assertInstanceOf(Entity::class, $findOne->entity);
    }

    public function testFindOneByCriteriaDAOFindTooMuchRows(): void
    {
        $this->expectException(EntityExpectOneButReceivedTooMuchException::class);

        self::$rows = [
            $this->prepareRow(),
            $this->prepareRow(),
        ];

        $findOne = EntityRetrieveByCriteriaDAO::new(self::$container);
        $findOne->expectOne = true;
        $findOne->allowEmptyResult = true;
        $findOne->serve();
    }

    public function testGetOneByCriteriaDAONotFound(): void
    {
        $this->expectException(EntityNotFoundException::class);

        $getOne = EntityRetrieveByCriteriaDAO::new(self::$container);
        $getOne->expectOne = true;
        $getOne->allowEmptyResult = false;
        $getOne->serve();
    }

    public function testGetManyByCriteriaDAONotFound(): void
    {
        $this->expectException(EntitiesNotFoundException::class);

        $getMany = EntityRetrieveByCriteriaDAO::new(self::$container);
        $getMany->expectOne = false;
        $getMany->allowEmptyResult = false;
        $getMany->serve();
    }

    public function testGetManyByCriteriaDAOFoundRows(): void
    {
        self::$rows = [
            $this->prepareRow(),
            $this->prepareRow(),
        ];

        $getMany = EntityRetrieveByCriteriaDAO::new(self::$container);
        $getMany->expectOne = false;
        $getMany->allowEmptyResult = false;
        $getMany->serve();

        self::assertNotEmpty($getMany->entities);
        self::assertCount(2, $getMany->entities);
        self::assertInstanceOf(Entity::class, $getMany->entities[0]);
        self::assertInstanceOf(Entity::class, $getMany->entities[1]);
    }

    public function testGetOneByCriteriaDAOFoundOneRow(): void
    {
        self::$rows = [
            $this->prepareRow(),
        ];

        $getOne = EntityRetrieveByCriteriaDAO::new(self::$container);
        $getOne->expectOne = true;
        $getOne->allowEmptyResult = false;
        $getOne->serve();

        self::assertNotEmpty($getOne->entity);
        self::assertInstanceOf(Entity::class, $getOne->entity);
    }

    public function testGetOneByCriteriaDAOFoundTooMuchRows(): void
    {
        $this->expectException(EntityExpectOneButReceivedTooMuchException::class);

        self::$rows = [
            $this->prepareRow(),
            $this->prepareRow(),
        ];

        $getOne = EntityRetrieveByCriteriaDAO::new(self::$container);
        $getOne->expectOne = true;
        $getOne->allowEmptyResult = false;
        $getOne->serve();
    }

    protected function prepareRow(): array
    {
        return [];
    }

    #[\Override]
    protected function mocks(ContainerInterface $c): array
    {
        return [
            EntityRetrieveByCriteriaDAO::class => fn() => new class($c) extends EntityRetrieveByCriteriaDAO {

                use \Tests\TestDatabaseConnectionTrait;

                #[\Override]
                protected function rowToEntity(array $row): Entity
                {
                    return new Entity;
                }

                #[\Override]
                protected function table(): string
                {
                    return 'table';
                }

                #[\Override]
                protected function createQb(): DatabaseQueryBuilder
                {
                    parent::createQb();

                    return $this->db()->createQueryBuilder()->select('1');
                }

                #[\Override]
                protected function rows(): array
                {
                    return EntityRetrieveByCriteriaDAOTest::$rows;
                }
            },
        ];
    }
}
