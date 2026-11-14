<?php

declare(strict_types=1);

namespace Tests\Module\RAD01\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\UUID;
use SetCMS\Database\DatabaseQueryBuilder;
use Module\RAD01\RAD01Constants;
use Module\RAD01\DAO\RAD01RetrieveByCriteriaDAO;
use Module\RAD01\Mapper\RAD01FromRowMapper;
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

    #[\Override]
    public function mocks(ContainerInterface $c): array
    {
        return [
            RAD01FromRowMapper::class => fn() => new class($c) extends RAD01FromRowMapper {

                #[\Override]
                protected function run(): void
                {
                    $this->entity = new RAD01Entity;
                }
            },
            RAD01RetrieveByCriteriaDAO::class => fn() => new class($c) extends RAD01RetrieveByCriteriaDAO {

                use \Tests\TestDatabaseConnectionTrait;

                #[\Override]
                protected function createQb(): DatabaseQueryBuilder
                {
                    RAD01RetrieveByCriteriaDAOTest::$qb = parent::createQb();

                    return $this->db()->createQueryBuilder()->select('1');
                }
            },
        ];
    }
}
