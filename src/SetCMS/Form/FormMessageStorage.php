<?php

declare(strict_types=1);

namespace SetCMS\Form;

use SetCMS\Form\Message\FormMessage;

class FormMessageStorage extends \SplObjectStorage
{

    public function current(): FormMessage
    {
        return parent::current();
    }

}
