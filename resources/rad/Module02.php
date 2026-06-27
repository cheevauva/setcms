<?php

declare(strict_types=1);

return [
    'moduleName' => 'Module02',
    'entityLc' => 'entity02lc',
    'entityUc' => 'Entity02',
    'tableName' => 'Table02',
    'fieldName' => 'field02',
    'dirs' => [
        '%s/Module/Module02/',
        '%s/Tests/Module/Module02/',
    ],
    'files' => [
        '%s/resources/acl/entity02lc.php',
        '%s/resources/routes/entity02lc.php',
        '%s/resources/migrations/sqlite/main/u.YmdHis.Table02.sql',
        '%s/resources/migrations/sqlite/main/d.YmdHis.Table02.sql',
        '%s/resources/templates/themes/bootstrap5/Entity02PrivateIndex.twig',
        '%s/resources/templates/themes/bootstrap5/Entity02PrivateEdit.twig',
        '%s/resources/templates/themes/bootstrap5/Entity02PrivateRead.twig',
    ],
];
