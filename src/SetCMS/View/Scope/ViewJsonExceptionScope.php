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
            if ($object instanceof Exception) {
                $this->data = $object->placeholders();
                $this->withMessage(CorePropertyMessageVO::fromArray([$object->label()]));
            } else {
                $this->withMessage(CorePropertyMessageVO::fromArray([$object->getMessage()]));
            }
        }
    }

    public function toArray(): array
    {
        return $this->data;
    }

}
