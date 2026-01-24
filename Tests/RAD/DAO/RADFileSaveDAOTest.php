<?php

declare(strict_types=1);

namespace Tests\RAD\DAO;

use SetCMS\RAD\Filesystem\FilesystemMemory;
use SetCMS\RAD\DAO\RADFileSaveDAO;
use SetCMS\RAD\VO\RADFsFileVO;
use SetCMS\RAD\VO\RADFsDirVO;

class RADFileSaveDAOTest extends \PHPUnit\Framework\TestCase
{

    use \Tests\TestTrait;

    public function testRADFileSaveDAO(): void
    {
        $container = self::$container;

        $filesystem = FilesystemMemory::singleton($container);

        $save = function ($file) use ($container, $filesystem) {
            $save = RADFileSaveDAO::new($container);
            $save->filesystem = $filesystem;
            $save->fileOrDir = $file;
            $save->serve();
        };

        $dir1 = new RADFsDirVO;
        $dir1->path = 'root';

        $save($dir1);

        $file = new RADFsFileVO();
        $file->path = 'root/1';
        $file->content = 'content1';

        $save($file);

        self::assertEquals($filesystem->isDir('root'), true);
        self::assertEquals($filesystem->isDir('root/1'), false);
        self::assertEquals($filesystem->isFile('root/1'), true);
        self::assertEquals($filesystem->fileGetContents('root/1'), 'content1');
    }
}
