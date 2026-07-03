<?php

$installer = [
    'acl' => [
        'version' => '0.1.1',
        'level' => 'core',
        'lang' => [
            'ru_RU' => [
                'name' => 'Cписок управления доступом',
                'description' => 'Cписок управления доступом (ACL), управления ролями и привелегиями',
            ],
        ],
        'files' => [
            'Module/ACL/Exception/ACLNotAllowException.php',
            'Module/ACL/Servant/ACLControllerServant.php',
            'Module/ACL/Servant/ACLCheckByRoleAndPrivilegeServant.php',
            'Module/ACL/ACL.php',
            'Module/ACL/VO/ACLRoleVO.php',
            'resources/events/acl.php',
            'resources/installer/acl.php',
            'resources/exceptionHandlers/acl.php',
        ],
    ],
];
