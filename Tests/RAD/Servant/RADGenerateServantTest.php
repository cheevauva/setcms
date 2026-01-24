<?php

declare(strict_types=1);

namespace Tests\RAD\Servant;

use Psr\Container\ContainerInterface;
use SetCMS\RAD\Servant\RADGenerateServant;
use SetCMS\RAD\DAO\RADFileFindManyDAO;
use SetCMS\RAD\VO\RADContextVO;
use SetCMS\RAD\VO\RADMetadataVO;
use SetCMS\RAD\VO\RADFsFileVO;
use SetCMS\RAD\VO\RADFsDirVO;

class RADGenerateServantTest extends \PHPUnit\Framework\TestCase
{

    use \Tests\TestTrait;

    public function testMain(): void
    {
        $metadata = new RADMetadataVO();
        $metadata->moduleName = 'moduleName';
        $metadata->entityLc = 'entityLc';
        $metadata->entityUc = 'entityUc';
        $metadata->tableName = 'tableName';
        $metadata->fieldName = 'fieldName';
        $metadata->dirs = [
            'dir2',
        ];
        $metadata->files = [
            'file1',
        ];

        $ctx = new RADContextVO();
        $ctx->moduleName = 'Account';
        $ctx->entityLc = 'account';
        $ctx->entityUc = 'Account';
        $ctx->tableName = 'accounts';
        $ctx->rootPath = 'rootPath';
        $ctx->currentDate = new \DateTimeImmutable('2020-01-01 01:01:01');
        $ctx->fields = [
            'field1',
            'field2',
            'field3',
        ];

        $generate = RADGenerateServant::new(self::$container);
        $generate->ctx = $ctx;
        $generate->meta = $metadata;
        $generate->serve();

        self::assertEquals('rootPath/Account/Account/accounts', RADFsDirVO::as($generate->files[0])->path);
        self::assertEquals('rootPath/Account/file1', RADFsFileVO::as($generate->files[1])->path);
        self::assertEquals(implode("\n", [
            '1',
            'public string $field1',
            'public string $field2',
            'public string $field3',
            'abc',
        ]), RADFsFileVO::as($generate->files[1])->content);
        self::assertEquals('rootPath/account/20200101010101', RADFsFileVO::as($generate->files[2])->path);
        self::assertEquals('20200101010101', RADFsFileVO::as($generate->files[2])->content);
    }

    protected function mocks(): \Closure
    {
        return fn(ContainerInterface $c) => [
            RADFileFindManyDAO::class => fn($c) => new class($c) extends RADFileFindManyDAO {

                #[\Override]
                public function serve(): void
                {
                    $dir = new RADFsDirVO();
                    $dir->path = $this->rootPath . '/moduleName/entityUc/tableName';

                    $file = new RADFsFileVO();
                    $file->path = $this->rootPath . '/entityUc/file1';
                    $file->content = implode("\n", [
                        '1',
                        'public string $fieldName',
                        'abc',
                    ]);

                    $file2 = new RADFsFileVO();
                    $file2->path = $this->rootPath . '/entityLc/YmdHis';
                    $file2->content = 'YmdHis';

                    $this->sources = [$dir, $file, $file2];
                }
            },
        ];
    }
}
