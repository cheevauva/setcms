<?php

declare(strict_types=1);

namespace SetCMS\Core\Form;

use SetCMS\Core\Form\Message\FormMessage;

class FormMessageStorage extends \SplObjectStorage
{

    public function current(): FormMessage
    {
        return parent::current();
    }

}
