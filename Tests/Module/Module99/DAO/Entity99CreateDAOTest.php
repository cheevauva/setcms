<?php

declare(strict_types=1);

namespace Tests\Module\Module99\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\Database\DatabaseQueryBuilder;
use Module\Module99\Module99Constants;
use Module\Module99\DAO\Entity99CreateDAO;

class Entity99CreateDAOTest extends \Tests\TestEasy
{

    use \Tests\Module\Module99\Entity99HelperTestTrait;

    public static ?DatabaseQueryBuilder $qb = null;

    #[\Override]
    protected function setUp(): void
    {
        self::$qb = null;
    }

    public function testEntity99CreateDAO(): void
    {
        $create = Entity99CreateDAO::new(self::$container);
        $create->entity99 = $this->prepareEntity();
        $create->serve();

        self::assertNotEmpty(self::$qb);

        if (empty(self::$qb)) {
            return;
        }

        $sql = self::$qb->getSQL();
        $params = self::$qb->getParameters();

        self::assertStringStartsWith('INSERT INTO ' . Module99Constants::TABLE_NAME, $sql);
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
            Entity99CreateDAO::class => fn() => new class($c) extends Entity99CreateDAO {

                use \Tests\TestDatabaseConnectionTrait;

                #[\Override]
                public function serve(): void
                {
                    Entity99CreateDAOTest::$qb = $this->createQuery();
                }
            },
        ];
    }
}
