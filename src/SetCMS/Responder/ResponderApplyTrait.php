<?php

namespace SetCMS\Responder;

use SetCMS\Action;
use SetCMS\Model;
use Psr\Http\Message\RequestInterface as Request;

trait ResponderApplyTrait
{

    protected Model $model;
    protected Request $request;

    public function apply(object $object): self
    {
        if ($object instanceof Request) {
            $this->request = $object;
        }

        if ($object instanceof Model) {
            $this->model = $object;
        }

        if ($object instanceof Action) {
            $object->apply($this);
        }

        return $this;
    }

}
