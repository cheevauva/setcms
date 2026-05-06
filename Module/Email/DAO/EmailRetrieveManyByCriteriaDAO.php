<?php

declare(strict_types=1);

namespace Module\Email\DAO;

use Module\Email\Entity\EmailEntity;
use Module\Email\Exception\EmailNotFoundException;
use Module\Email\Exception\EmailsNotFoundException;
use Module\Email\Exception\EmailExpectOneButReceivedTooMuchException;
use Module\Email\Mapper\EmailFromRowMapper;

class EmailRetrieveManyByCriteriaDAO extends \UUA\DAO
{

    use \SetCMS\DAO\DAOEntityRetrieveByCriteriaTrait;
    use \Module\Email\Traits\EmailDbalDAOTrait;

    /**
     * @var array<EmailEntity>
     */
    public protected(set) array $emails;
    public protected(set) EmailEntity $email;
    public protected(set) ?EmailEntity $emailOrNull = null;

    #[\Override]
    protected function entitiesNotFoundException(): \Throwable
    {
        return new EmailsNotFoundException();
    }

    #[\Override]
    protected function entityExpectOneButReceivedTooMuchException(): \Throwable
    {
        return new EmailExpectOneButReceivedTooMuchException;
    }

    #[\Override]
    protected function entityNotFoundException(): \Throwable
    {
        return new EmailNotFoundException();
    }

    #[\Override]
    protected function handleRows(array $rows): void
    {
        $this->emails = array_map(fn($row) => EmailFromRowMapper::call($this->container, $row)->email, $rows);
        $this->emails ? $this->email = $this->emailOrNull = $this->emails[0] : null;
    }
}
