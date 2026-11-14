<?php

declare(strict_types=1);

namespace Module\Email\DAO;

use Module\Email\Mapper\EmailFromRowMapper;
use Module\Email\Entity\EmailEntity;
use SetCMS\Entity\DAO\EntityRetrieveByCriteriaDAO;

/**
 * @extends EntityRetrieveByCriteriaDAO<EmailEntity>
 */
class EmailRetrieveManyByCriteriaDAO extends EntityRetrieveByCriteriaDAO
{

    use \Module\Email\Traits\EmailDbalDAOTrait;

    #[\Override]
    protected function rowToEntity(array $row): EmailEntity
    {
        return EmailFromRowMapper::call($this, $row)->entity;
    }
}
