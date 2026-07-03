<?php

declare(strict_types=1);

namespace Module\RAD\Servant;

use Module\RAD\DAO\RADFileFindManyDAO;
use Module\RAD\VO\RADContextVO;
use Module\RAD\VO\RADMetadataVO;
use Module\RAD\VO\RADFsVO;
use Module\RAD\VO\RADFsFileVO;
use Module\RAD\VO\RADFsDirVO;
use Module\RAD\Filesystem\FilesystemBase;

class RADGenerateServant extends \UUA\Servant
{

    public FilesystemBase $filesystem;
    public RADContextVO $ctx;
    public RADMetadataVO $meta;

    /**
     * @var array<RADFsVO>
     */
    public array $files;

    #[\Override]
    public function serve(): void
    {
        $findFiles = RADFileFindManyDAO::new($this->container);
        $findFiles->scanDirs = $this->meta->dirs;
        $findFiles->scanFiles = $this->meta->files;
        $findFiles->rootPath = $this->ctx->rootPath;
        $findFiles->filesystem = $this->filesystem;
        $findFiles->serve();

        $this->files = [];

        foreach ($findFiles->sources as $source) {
            if ($source instanceof RADFsDirVO) {
                $newDir = new RADFsDirVO();
                $newDir->path = $this->prepareFilename($source);

                $this->files[] = $newDir;
            }

            if ($source instanceof RADFsFileVO) {
                $newFile = new RADFsFileVO();
                $newFile->path = $this->prepareFilename($source);
                $newFile->content = $this->prepareContent($source);

                $this->files[] = $newFile;
            }
        }
    }

    /**
     * @return array<string, mixed>
     */
    protected function prepareParts(): array
    {
        return [
            'YmdHis' => $this->ctx->currentDate->format('YmdHis'),
            $this->meta->moduleName => ucfirst($this->ctx->moduleName),
            $this->meta->entityLc => lcfirst($this->ctx->entityLc),
            $this->meta->entityUc => ucfirst($this->ctx->entityUc),
            $this->meta->tableName => strtolower($this->ctx->tableName),
        ];
    }

    public function prepareFilename(RADFsVO $source): string
    {
        return strtr($source->path, $this->prepareParts());
    }

    public function prepareContent(RADFsFileVO $source): string
    {
        $targetContent = strtr($source->content, $this->prepareParts());

        $lines = [];

        foreach (explode("\n", $targetContent) as $line) {
            if (!str_contains($line, $this->meta->fieldName)) {
                $lines[] = $line;
                continue;
            }

            foreach ($this->ctx->fields as $field) {
                $lines[] = str_replace($this->meta->fieldName, $field, $line);
            }
        }

        return implode("\n", $lines);
    }
}
