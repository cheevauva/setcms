<?php

declare(strict_types=1);

namespace SetCMS\Controller;

use SetCMS\Form;
use SetCMS\ServantInterface;

trait ControllerTrait
{

    protected function serve(ServantInterface $servant, Form $form, array $array = []): Form
    {
        $form->fromArray($array);

        try {
            if ($form->valid()) {
                $form->to($servant);
                $servant->serve();
                $form->from($servant);
            }
        } catch (\Exception $ex) {
            $form->apply($ex);
        }

        return $form;
    }

}
