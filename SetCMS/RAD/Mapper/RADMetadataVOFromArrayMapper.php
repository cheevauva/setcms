<?php

declare(strict_types=1);

namespace SetCMS\RAD\Mapper;

use SetCMS\RAD\VO\RADMetadataVO;

class RADMetadataVOFromArrayMapper extends \UUA\Mapper
{

    /**
     * @var array<string, mixed>
     */
    public array $array;
    public RADMetadataVO $metadata;

    #[\Override]
    public function serve(): void
    {
        $dirs = $this->array['dirs'] ?? throw new \Exception('dirs должен быть задан');
        $files = $this->array['files'] ?? throw new \Exception('files должен быть задан');
        $tableName = $this->array['tableName'] ?? throw new \Exception('tableName должен быть задан');
        $moduleName = $this->array['moduleName'] ?? throw new \Exception('moduleName должен быть задан');
        $entityLc = $this->array['entityLc'] ?? throw new \Exception('entityLc должен быть задан');
        $entityUc = $this->array['entityUc'] ?? throw new \Exception('entityUc должен быть задан');
        $fieldName = $this->array['fieldName'] ?? throw new \Exception('fieldName должен быть задан');

        !is_array($dirs) ? throw new \Exception('dirs должен быть массивом') : null;
        !is_array($files) ? throw new \Exception('files должен быть массивом') : null;
        !is_string($tableName) ? throw new \Exception('tableName должен быть строкой') : null;
        !is_string($moduleName) ? throw new \Exception('moduleName должен быть строкой') : null;
        !is_string($entityLc) ? throw new \Exception('entityLc должен быть строкой') : null;
        !is_string($entityUc) ? throw new \Exception('entityUc должен быть строкой') : null;

        $this->metadata = new RADMetadataVO();
        $this->metadata->dirs = $dirs;
        $this->metadata->files = $files;
        $this->metadata->tableName = $tableName;
        $this->metadata->moduleName = $moduleName;
        $this->metadata->entityLc = $entityLc;
        $this->metadata->entityUc = $entityUc;
        $this->metadata->fieldName = $fieldName;
    }
}
