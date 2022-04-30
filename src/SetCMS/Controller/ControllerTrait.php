<?php

declare(strict_types=1);

namespace SetCMS\Controller;

use SetCMS\Core\Form;
use SetCMS\ServantInterface;

trait ControllerTrait
{

    protected function serve(ServantInterface $servant, Form $form, array $array): Form
    {
        $form->fromArray($array);

        try {
            if ($form->valid()) {
                $form->apply($servant);
                $servant->serve();
                $form->apply($servant);
            }
        } catch (\Throwable $ex) {
            $form->apply($ex);
        }

        return $form;
    }

}
