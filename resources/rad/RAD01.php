<?php

declare(strict_types=1);

return [
    'moduleName' => 'RAD01',
    'entityLc' => 'rad01lc',
    'entityUc' => 'RAD01',
    'tableName' => 'Table01',
    'fieldName' => 'field01',
    'dirs' => [
        '%s/Module/RAD01/',
        '%s/Tests/Module/RAD01/',
    ],
    'files' => [
        '%s/resources/acl/rad01.php',
        '%s/resources/routes/rad01.php',
        '%s/resources/wrappers/rad01.php',
        '%s/resources/migrations/sqlite/main/u.YmdHis.Table01.sql',
        '%s/resources/migrations/sqlite/main/d.YmdHis.Table01.sql',
        '%s/resources/templates/themes/bootstrap5/RAD01PrivateIndex.twig',
        '%s/resources/templates/themes/bootstrap5/RAD01PrivateEdit.twig',
        '%s/resources/templates/themes/bootstrap5/RAD01PrivateRead.twig',
    ],
];
