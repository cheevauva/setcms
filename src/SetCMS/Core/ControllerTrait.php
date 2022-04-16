<?php

declare(strict_types=1);

namespace SetCMS\Core;

use SetCMS\Core\Form;
use SetCMS\Core\ServantInterface;
use Exception;

trait ControllerTrait
{

    protected function serve(ServantInterface $servant, Form $form, array $array): Form
    {
        $form->fromArray($array);

        try {
            if ($form->isValid()) {
                $form->apply($servant);
                $servant->serve();
                $form->apply($servant);
            }
        } catch (Exception $ex) {
            $form->apply($ex);
        }

        return $form;
    }

}
