<?php

declare(strict_types=1);

namespace SetCMS\Module\CronSchedulerWork\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\CronSchedulerWork\Entity\CronSchedulerWorkEntity;
use SetCMS\Module\CronSchedulerWork\Servant\CronSchedulerWorkCreateServant;
use SetCMS\Module\CronSchedulerWork\View\CronSchedulerWorkPrivateCreateView;
use SetCMS\Module\CronSchedulerWork\Enum\CronSchedulerWorkStatusEnum;

class CronSchedulerWorkPrivateCreateController extends ControllerViaPSR7
{

    protected CronSchedulerWorkEntity $cronSchedulerWork;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            CronSchedulerWorkCreateServant::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            CronSchedulerWorkPrivateCreateView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {
        $body = $this->request->getParsedBody() ?? [];

        $validation = $this->validation($body);
        $validation->array('cronSchedulerWork')->notEmpty()->validate();

        $this->cronSchedulerWork = new CronSchedulerWorkEntity();
        $this->cronSchedulerWork->id = $validation->uuid('cronSchedulerWork.id')->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof CronSchedulerWorkCreateServant) {
            $object->cronSchedulerWork = $this->cronSchedulerWork;
        }

        if ($object instanceof CronSchedulerWorkPrivateCreateView) {
            $object->cronSchedulerWork = $this->cronSchedulerWork;
        }
    }
}
