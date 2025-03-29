<?php

declare(strict_types=1);

namespace UUA;

abstract class Responder extends Unit
{

    use \UUA\Traits\AsTrait;
    use \UUA\Traits\ContainerTrait;
    use \UUA\Traits\BuildTrait;
}
