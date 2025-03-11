<?php

declare(strict_types=1);

namespace SetCMS\Module\Migration\Version\Main;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Migration20241208220051Version extends AbstractMigration
{

    public function getDescription(): string
    {
        return 'admin:administrator';
    }

    public function up(Schema $schema): void
    {
        $sql = "
        INSERT INTO users 
        (
            username,
            password, 
            role,
            id,
            entity_type,
            date_created,
            date_modified, 
            deleted
        ) 
        VALUES 
        (
            'admin',
            '$2y$12$5tfZoh2e0GCjShqeVybxsOJI7PdPRGdge8sxz2q0MNiwTNjRimoqO',
            'admin',
            'c5e35038-4d12-4d90-be57-f4eb1a45fe35',	
            'SetCMS\Module\User\Entity\UserEntity',
            NOW(),
            NOW(),
            'f'
        )
        ";
        
        $this->addSql($sql);
    }


    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM users WHERE id = 'c5e35038-4d12-4d90-be57-f4eb1a45fe35'");
    }
}
