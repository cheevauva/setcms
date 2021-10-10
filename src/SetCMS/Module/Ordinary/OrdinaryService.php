<?php

namespace SetCMS\Module\Ordinary;

use SetCMS\Module\Ordinary\OrdinaryDAO;
use SetCMS\Module\Ordinary\OrdinaryEntity;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelRead;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelList;

abstract class OrdinaryService
{

    abstract protected function dao(): OrdinaryDAO;

    abstract protected function entity(): OrdinaryEntity;

    public function read(OrdinaryModelRead $model): void
    {
        $model->entity($this->dao()->getById($model->id));
    }

    public function list(OrdinaryModelList $model): void
    {
        $model->entities($this->dao()->list($model->page, 10, 'id', 'DESC'));
    }

    public function save(OrdinaryModel $model): void
    {
        $model->entity(!empty($model->id) ? $this->dao()->getById((int) $model->id) : $this->entity());
        $model->entity()->dateModified = new \DateTime;

        $this->dao()->save($model->entity());
    }

}
