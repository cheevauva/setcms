<?php

declare(strict_types=1);

namespace Module\Migration\Mapper;

class MigrationUpFromRequestMapper extends \SetCMS\Mapper\MapperFromRequest
{

    public protected(set) string $dbName;
    public protected(set) string $secretKey;

    #[\Override]
    public function serve(): void
    {
        $validation = $this->validationBody();

        $this->dbName = $validation->string('dbName')->notEmpty()->val();
        $this->secretKey = $validation->string('secretKey')->notEmpty()->val();
    }
}
