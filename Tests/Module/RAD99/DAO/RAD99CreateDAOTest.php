<?php

declare(strict_types=1);

namespace Tests\Module\RAD99\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\Database\DatabaseQueryBuilder;
use Module\RAD99\RAD99Constants;
use Module\RAD99\DAO\RAD99CreateDAO;

class RAD99CreateDAOTest extends \Tests\TestEasy
{

    use \Tests\Module\RAD99\RAD99HelperTestTrait;

    public static ?DatabaseQueryBuilder $qb = null;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        
        self::$qb = null;
    }

    public function testRAD99CreateDAO(): void
    {
        $create = RAD99CreateDAO::new(self::$container);
        $create->rad99 = $this->prepareEntity();
        $create->serve();

        self::assertNotEmpty(self::$qb);

        if (empty(self::$qb)) {
            return;
        }

        $sql = self::$qb->getSQL();
        $params = self::$qb->getParameters();

        self::assertStringStartsWith('INSERT INTO ' . RAD99Constants::TABLE_NAME, $sql);
        self::assertStringContainsString('id, created_by, modified_by, assigned_by, entity_type, date_created, date_modified, deleted', $sql);
        self::assertStringContainsString(':id, :created_by, :modified_by, :assigned_by, :entity_type, :date_created, :date_modified, :deleted', $sql);
        self::assertStringContainsString(', field99', $sql);
        self::assertStringContainsString(', :field99', $sql);
        self::assertEquals($this->prepareRow(), $params);
    }

    #[\Override]
    protected function mocks(ContainerInterface $c): array
    {
        return [
            RAD99CreateDAO::class => fn() => new class($c) extends RAD99CreateDAO {

                use \Tests\TestDatabaseConnectionTrait;

                #[\Override]
                public function serve(): void
                {
                    RAD99CreateDAOTest::$qb = $this->createQuery();
                }
            },
        ];
    }
}
