<?php

declare(strict_types=1);

namespace Tests\Module\Module99\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\Database\DatabaseQueryBuilder;
use Module\Module99\Module99Constants;
use Module\Module99\DAO\Entity99UpdateDAO;

class Entity99UpdateDAOTest extends \Tests\TestEasy
{

    use \Tests\Module\Module99\Entity99HelperTestTrait;

    public static ?DatabaseQueryBuilder $qb = null;

    #[\Override]
    protected function setUp(): void
    {
        self::$qb = null;
    }

    public function testEntity99UpdateDAO(): void
    {
        $create = Entity99UpdateDAO::new(self::$container);
        $create->entity99 = $this->prepareEntity();
        $create->serve();

        self::assertNotEmpty(self::$qb);

        if (empty(self::$qb)) {
            return;
        }

        $sql = self::$qb->getSQL();
        $params = self::$qb->getParameters();

        self::assertStringStartsWith('UPDATE ' . Module99Constants::TABLE_NAME, $sql);
        self::assertStringContainsString('id = :id', $sql);
        self::assertStringContainsString('created_by = :created_by', $sql);
        self::assertStringContainsString('modified_by = :modified_by', $sql);
        self::assertStringContainsString('assigned_by = :assigned_by', $sql);
        self::assertStringContainsString('entity_type = :entity_type', $sql);
        self::assertStringContainsString('date_created = :date_created', $sql);
        self::assertStringContainsString('date_modified = :date_modified', $sql);
        self::assertStringContainsString('deleted = :deleted', $sql);
        self::assertStringContainsString('field99 = :field99', $sql);
        self::assertEquals($this->prepareRow(), $params);
    }

    #[\Override]
    protected function mocks(ContainerInterface $c): array
    {
        return [
            Entity99UpdateDAO::class => fn() => new class($c) extends Entity99UpdateDAO {

                use \Tests\TestDatabaseConnectionTrait;

                #[\Override]
                public function serve(): void
                {
                    Entity99UpdateDAOTest::$qb = $this->createQuery();
                }
            },
        ];
    }
}
