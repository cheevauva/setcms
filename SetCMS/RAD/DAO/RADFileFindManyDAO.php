<?php

declare(strict_types=1);

namespace SetCMS\RAD\DAO;

use SetCMS\RAD\VO\RADFsFileVO;
use SetCMS\RAD\VO\RADFsDirVO;
use SetCMS\RAD\VO\RADFsVO;
use SetCMS\RAD\Filesystem\FilesystemBase;

class RADFileFindManyDAO extends \UUA\DAO
{

    public string $rootPath;

    /**
     * @var array<string>
     */
    public array $scanDirs;

    /**
     * @var array<string>
     */
    public array $scanFiles;

    /**
     * @var array<RADFsVO>
     */
    public protected(set) array $sources;
    
    public FilesystemBase $filesystem;

    #[\Override]
    public function serve(): void
    {
        $filesFromDir = [];

        foreach ($this->scanDirs as $dir) {
            $filesFromDir[] = $this->filesystem->getFiles(sprintf($dir, $this->rootPath));
        }

        $files = array_merge(...$filesFromDir);

        foreach ($this->scanFiles as $file) {
            $files[] = sprintf($file, $this->rootPath);
        }

        $this->sources = [];

        $files = array_unique($files);

        foreach ($files as $path) {
            if ($this->filesystem->isFile($path)) {
                $srcFile = new RADFsFileVO();
                $srcFile->path = $path;
                $srcFile->content = $this->filesystem->fileGetContents($path);

                $this->sources[] = $srcFile;
            }

            if ($this->filesystem->isDir($path)) {
                $srcDir = new RADFsDirVO();
                $srcDir->path = $path;

                $this->sources[] = $srcDir;
            }
        }
    }
}
