<?php

declare(strict_types=1);

namespace SetCMS\Module\Email\DAO;

use SetCMS\Common\DAO\EntitySaveDAO;
use SetCMS\Module\Email\Entity\EmailEntity;

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
