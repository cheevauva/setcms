<?php

declare(strict_types=1);

namespace Tests\Module\RAD99\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\Database\DatabaseQueryBuilder;
use Module\RAD99\RAD99Constants;
use Module\RAD99\DAO\RAD99UpdateDAO;

class RAD99UpdateDAOTest extends \Tests\TestEasy
{

    use \Tests\Module\RAD99\RAD99HelperTestTrait;

    public static ?DatabaseQueryBuilder $qb = null;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        
        self::$qb = null;
    }

    public function testRAD99UpdateDAO(): void
    {
        $create = RAD99UpdateDAO::new(self::$container);
        $create->rad99 = $this->prepareEntity();
        $create->serve();

        self::assertNotEmpty(self::$qb);

        if (empty(self::$qb)) {
            return;
        }

        $sql = self::$qb->getSQL();
        $params = self::$qb->getParameters();

        self::assertStringStartsWith('UPDATE ' . RAD99Constants::TABLE_NAME, $sql);
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
            RAD99UpdateDAO::class => fn() => new class($c) extends RAD99UpdateDAO {

                use \Tests\TestDatabaseConnectionTrait;

                #[\Override]
                public function serve(): void
                {
                    RAD99UpdateDAOTest::$qb = $this->createQuery();
                }
            },
        ];
    }
}
