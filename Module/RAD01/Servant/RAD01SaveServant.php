<?php

declare(strict_types=1);

namespace Module\RAD01\Servant;

use Module\RAD01\DAO\RAD01HasByIdDAO;
use Module\RAD01\DAO\RAD01CreateDAO;
use Module\RAD01\DAO\RAD01UpdateDAO;

class RAD01SaveServant extends \UUA\Servant
{

    use \Module\RAD01\Traits\RAD01CallTrait;

    #[\Override]
    protected function run(): void
    {
        if (RAD01HasByIdDAO::call($this, $this->rad01->id)->isExists) {
            RAD01UpdateDAO::call($this, $this->rad01);
        } else {
            RAD01CreateDAO::call($this, $this->rad01);
        }
    }
}
