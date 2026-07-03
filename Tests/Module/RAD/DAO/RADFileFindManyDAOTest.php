<?php

declare(strict_types=1);

namespace Tests\RAD\DAO;

use Module\RAD\Filesystem\FilesystemMemory;
use Module\RAD\DAO\RADFileFindManyDAO;
use Module\RAD\VO\RADFsDirVO;
use Module\RAD\VO\RADFsFileVO;

class RADFileFindManyDAOTest extends \Tests\TestEasy
{

    public function testRADFileFindManyDAO(): void
    {
        $fs = FilesystemMemory::singleton(self::$container);
        $fs->makeDir('root/dir1');
        $fs->makeDir('root/dir3');
        $fs->makeDir('root/dir1/subdir1');
        $fs->filePutContents('root/dir1/file1', 'content1');
        $fs->filePutContents('root/dir1/file2', 'content2');
        $fs->filePutContents('root/dir2/file1', 'content3');
        $fs->filePutContents('root/dir2/file2', 'content4');

        $findFiles = RADFileFindManyDAO::new(self::$container);
        $findFiles->filesystem = $fs;
        $findFiles->rootPath = 'rootPath';
        $findFiles->scanDirs = [
            'root/dir1',
        ];
        $findFiles->scanFiles = [
            'root/dir2/file1',
            'root/dir2/file2',
        ];
        $findFiles->serve();

        self::assertCount(5, $findFiles->sources);
        self::assertEquals(RADFsDirVO::as($findFiles->sources[0])->path, 'root/dir1/subdir1');
        self::assertEquals(RADFsFileVO::as($findFiles->sources[1])->path, 'root/dir1/file1');
        self::assertEquals(RADFsFileVO::as($findFiles->sources[2])->path, 'root/dir1/file2');
        self::assertEquals(RADFsFileVO::as($findFiles->sources[3])->path, 'root/dir2/file1');
        self::assertEquals(RADFsFileVO::as($findFiles->sources[4])->path, 'root/dir2/file2');
        self::assertEquals(RADFsFileVO::as($findFiles->sources[1])->content, 'content1');
        self::assertEquals(RADFsFileVO::as($findFiles->sources[2])->content, 'content2');
        self::assertEquals(RADFsFileVO::as($findFiles->sources[3])->content, 'content3');
        self::assertEquals(RADFsFileVO::as($findFiles->sources[4])->content, 'content4');
    }
}
