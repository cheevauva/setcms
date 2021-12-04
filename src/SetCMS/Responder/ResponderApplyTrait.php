<?php

namespace SetCMS\Responder;

use SetCMS\Action;
use SetCMS\Model;
use Psr\Http\Message\RequestInterface as Request;

trait ResponderApplyTrait
{

    protected Action $action;
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
            $this->action = $object;
        }

        return $this;
    }

}
