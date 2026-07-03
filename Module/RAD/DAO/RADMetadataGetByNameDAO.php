<?php

declare(strict_types=1);

namespace Module\RAD\DAO;

use Module\RAD\Filesystem\FilesystemBase;
use Module\RAD\VO\RADMetadataVO;
use Module\RAD\Mapper\RADMetadataVOFromArrayMapper;
use Module\RAD\Exception\RADMetadataNotFoundException;

class RADMetadataGetByNameDAO extends \UUA\DAO
{

    use \UUA\Traits\EnvTrait;

    public string $name;
    public protected(set) RADMetadataVO $metadata;
    public FilesystemBase $filesystem;

    #[\Override]
    public function serve(): void
    {
        $filename = sprintf('%s/resources/rad/%s.php', $this->env()['ROOT_PATH'], $this->name);

        if (!$this->filesystem->hasFile($filename)) {
            throw new RADMetadataNotFoundException($this->name);
        }

        $mapper = RADMetadataVOFromArrayMapper::new($this->container);
        $mapper->array = $this->filesystem->loadArrayFromPHPFile($filename);
        $mapper->serve();

        $this->metadata = $mapper->metadata;
    }
}
