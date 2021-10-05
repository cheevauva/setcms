<?php

namespace SetCMS\Module\Ordinary;

use SetCMS\Module\Ordinary\OrdinaryDAO;
use SetCMS\Module\Ordinary\OrdinaryEntity;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelSave;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelRead;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelList;

abstract class OrdinaryService
{

    abstract protected function dao(): OrdinaryDAO;

    abstract protected function newEntity(): OrdinaryEntity;

    public function read(OrdinaryModelRead $model): OrdinaryModelRead
    {
        if (!$model->isValid()) {
            return $model;
        }

        $model->entity($this->dao()->getById($model->id));

        return $model;
    }

    public function list(OrdinaryModelList $model): OrdinaryModelList
    {
        if (!$model->isValid()) {
            return $model;
        }

        $model->entities($this->dao()->list($model->page));

        return $model;
    }

    public function save(OrdinaryModelSave $model): OrdinaryModelSave
    {
        if (!$model->isValid()) {
            return $model;
        }

        $model->entity(!empty($model->id) ? $this->dao()->getById((int) $model->id) : $this->newEntity());
        $model->prepareEntity();
        
        $model->entity()->dateModified = new \DateTime;

        $this->dao()->save($model->entity());

        return $model;
    }

}
