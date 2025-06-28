<?php

declare(strict_types=1);

namespace SetCMS;

use ArrayObject;

abstract class ControllerViaEmbedded extends Controller
{

    /**
     * @var ArrayObject<string, mixed>
     */
    public ArrayObject $embedded;
}
