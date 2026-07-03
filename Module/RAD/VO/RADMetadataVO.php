<?php

declare(strict_types=1);

namespace Module\RAD\VO;

class RADMetadataVO extends \UUA\VO
{

    public string $moduleName;
    public string $entityLc;
    public string $entityUc;
    public string $tableName;
    public string $fieldName;

    /**
     * @var array<string>
     */
    public array $files;

    /**
     * @var array<string>
     */
    public array $dirs;
    

}
