<?php

declare(strict_types=1);

namespace SetCMS\Module\Email\DAO;

use SetCMS\Module\Email\Entity\EmailEntity;
use SetCMS\Module\Email\Exception\EmailNotFoundException;

class EmailRetrieveManyByCriteriaDAO extends \SetCMS\Common\DAO\EntityRetrieveManyByCriteriaDAO
{

    use EmailCommonDAO;

    /**
     * @var array<EmailEntity>
     */
    public array $emails;
    public ?EmailEntity $email;

    #[\Override]
    public function serve(): void
    {
        parent::serve();

        $this->emails = EmailEntity::manyAs($this->entities);
        $this->email = $this->first ? EmailEntity::as($this->first) : null;
    }

    #[\Override]
    protected function notFoundExcecption(): \Throwable
    {
        return new EmailNotFoundException();
    }
}
