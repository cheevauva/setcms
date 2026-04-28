<?php

declare(strict_types=1);

namespace SetCMS\RAD\DAO;

use SetCMS\RAD\VO\RADFsVO;
use SetCMS\RAD\VO\RADFsDirVO;
use SetCMS\RAD\VO\RADFsFileVO;
use SetCMS\RAD\Exception\RADFileAlreadyExistsException;
use SetCMS\RAD\Filesystem\FilesystemBase;

class RADFileSaveDAO extends \UUA\DAO
{

    public RADFsVO $fileOrDir;
    public FilesystemBase $filesystem;

    #[\Override]
    public function serve(): void
    {
        $path = $this->fileOrDir->path;

        if ($this->fileOrDir instanceof RADFsDirVO && !$this->filesystem->isDir($path)) {
            $this->filesystem->makeDir($path, 0777, true);
            return;
        }

        if ($this->filesystem->hasFile($path)) {
            throw new RADFileAlreadyExistsException($path);
        }

        $this->filesystem->filePutContents($path, RADFsFileVO::as($this->fileOrDir)->content);
        $this->filesystem->changeMode($path, 0777);
    }
}
