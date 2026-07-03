<?php

$installer = [
    'basic' => [
        'version' => '0.1.1',
        'level' => 'core',
        'lang' => [
            'ru_RU' => [
                'name' => 'Базовый модуль с пользователями',
                'description' => 'Базовый модуль используемый для расширения другими модулями, в нем есть поля ответственный, создатель, редактор, дата создания и модификации',
            ],
        ],
        'files' => [
            'Module/Basic/DAO/BasicEntityRetrieveByCriteriaDAO.php',
            'Module/Basic/Entity/BasicEntity.php',
            'Module/Basic/Mapper/BasicEntityFromRowMapper.php',
            'Module/Basic/Mapper/BasicEntityToRowMapper.php',
            'resources/installer/basic.php',
        ],
    ],
];
