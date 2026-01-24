<?php

declare(strict_types=1);

namespace SetCMS\RAD\VO;

class RADContextVO extends \UUA\VO
{

    public string $moduleName;
    public string $entityLc;
    public string $entityUc;
    public string $tableName;
    public string $rootPath;
    public \DateTimeImmutable $currentDate;

    /**
     * @var array<string>
     */
    public array $fields;
}
