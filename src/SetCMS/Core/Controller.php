<?php

declare(strict_types=1);

namespace SetCMS\Core;

use Psr\Http\Message\ServerRequestInterface;
use SetCMS\Core\Form;
use SetCMS\Core\Entity;
use SetCMS\Core\Entity\DAO\EntityRetrieveByIdDAO;
use SetCMS\Core\Entity\DAO\EntityRetrieveByCriteriaDAO;
use SetCMS\Core\Entity\DAO\EntitySaveDAO;
use SetCMS\Core\Entity\Exception\EntityNotFoundException;
use Exception;

abstract class Controller
{

    protected function readById(ServerRequestInterface $request, Form $form, EntityRetrieveByIdDAO $retrieveEntityById): Form
    {
        $params = $request->getQueryParams();
        $params['id'] = $request->getAttribute('id') ?? null;

        $form->fromArray($params);

        return $this->readByCriteria($form, $retrieveEntityById);
    }

    protected function readByCriteria(Form $form, EntityRetrieveByCriteriaDAO $retrieveEntityDAO): Form
    {
        if (!$form->isValid()) {
            return $form;
        }

        try {
            $form->apply($retrieveEntityDAO);
            $retrieveEntityDAO->serve();
            $form->apply($retrieveEntityDAO->entity);
        } catch (Exception $ex) {
            $form->apply($ex);
        }

        return $form;
    }

    protected function saveById(ServerRequestInterface $request, Form $form, EntityRetrieveByIdDAO $retrieveEntityById, EntitySaveDAO $saveEntity, Entity $newEntity): Form
    {
        $params = $request->getParsedBody();
        $params['id'] = $request->getAttribute('id') ?? null;

        $form->fromArray($params);

        if (!$form->isValid()) {
            return $form;
        }

        try {
            $form->apply($retrieveEntityById);

            $retrieveEntityById->serve();

            $form->apply($retrieveEntityById->entity);

            $saveEntity->entity = $retrieveEntityById->entity;
            $saveEntity->serve();
        } catch (EntityNotFoundException $ex) {
            $form->apply($newEntity);

            $saveEntity->entity = $newEntity;
            $saveEntity->serve();
        } catch (Exception $ex) {
            $form->apply($ex);
        }

        return $form;
    }

}
