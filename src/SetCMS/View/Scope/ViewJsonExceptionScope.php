<?php

declare(strict_types=1);

namespace SetCMS\View\Scope;

use SetCMS\Scope;
use SetCMS\Exception;
use SetCMS\Core\VO\CorePropertyMessageVO;

class ViewJsonExceptionScope extends Scope
{

    protected array $data = [];

    public function from(object $object): void
    {
        if ($object instanceof \Throwable) {
            $this->catchToMessage(null, $object);
        }
    }

    public function toArray(): array
    {
        return $this->data;
    }

}
