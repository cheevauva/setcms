<?php

declare(strict_types=1);

namespace Module\Email\DAO;

use SetCMS\DAO\EntitySaveDAO;
use Module\Email\Entity\EmailEntity;

class EmailSaveDAO extends EntitySaveDAO
{

    use EmailCommonDAO;

    public EmailEntity $email;

    #[\Override]
    public function serve(): void
    {
        $this->entity = $this->email;

        parent::serve();
    }
}
