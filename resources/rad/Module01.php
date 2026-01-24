<?php

declare(strict_types=1);

return [
    'moduleName' => 'Module01',
    'entityLc' => 'entity01lc',
    'entityUc' => 'Entity01',
    'tableName' => 'Table01',
    'fieldName' => 'field01',
    'dirs' => [
        '%s/Module/Module01/',
        '%s/Tests/Module/Module01/',
    ],
    'files' => [
        '%s/resources/acl/entity01lc.php',
        '%s/resources/routes/entity01lc.php',
        '%s/resources/entities/entity01lc.php',
        '%s/resources/wrappers/entity01lc.php',
        '%s/resources/migrations/sqlite/main/u.YmdHis.Table01.sql',
        '%s/resources/migrations/sqlite/main/d.YmdHis.Table01.sql',
        '%s/resources/templates/themes/bootstrap5/Entity01PrivateIndex.twig',
        '%s/resources/templates/themes/bootstrap5/Entity01PrivateEdit.twig',
        '%s/resources/templates/themes/bootstrap5/Entity01PrivateRead.twig',
    ],
];
