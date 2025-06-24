<?php

declare(strict_types=1);

namespace SetCMS\Module\Email\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\Email\DAO\EmailRetrieveManyByCriteriaDAO;
use SetCMS\Module\Email\View\EmailPrivateIndexView;
use SetCMS\Module\Email\Entity\EmailEntity;

class EmailPrivateIndexController extends ControllerViaPSR7
{

    /**
     * @var EmailEntity[]
     */
    protected array $emails = [];

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            EmailRetrieveManyByCriteriaDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            EmailPrivateIndexView::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof EmailRetrieveManyByCriteriaDAO) {
            $this->emails = $object->emails;
        }
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);
        
        if ($object instanceof EmailPrivateIndexView) {
            $object->emails = $this->emails;
        }
    }
}
