<?php

declare(strict_types=1);

namespace Module\Page\Exception;

class PagesNotFoundException extends PageException
{

    use \SetCMS\Exception\ExceptionEntitiesNotFoundTrait;
}
