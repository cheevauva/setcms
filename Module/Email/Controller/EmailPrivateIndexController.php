<?php

declare(strict_types=1);

namespace Module\Email\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Email\DAO\EmailRetrieveManyByCriteriaDAO;
use Module\Email\View\EmailPrivateIndexView;
use Module\Email\Entity\EmailEntity;

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
