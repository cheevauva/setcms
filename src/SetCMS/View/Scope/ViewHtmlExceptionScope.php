<?php

declare(strict_types=1);

namespace SetCMS\View\Scope;

use SetCMS\Exception;

class ViewHtmlExceptionScope extends ViewJsonExceptionScope
{

    public function from(object $object): void
    {
        if ($object instanceof \Throwable) {
            if ($object instanceof Exception) {
                $this->data = [
                    'label' => $object->label(),
                    'placeholders' => $object->placeholders(),
                ];
            } else {
                $this->data = [
                    'label' => $object->getMessage(),
                    'placeholders' => []
                ];
            }
        }
    }

}
