<?php

declare(strict_types=1);

namespace SetCMS;

use SplObjectStorage;
use Psr\Http\Message\ResponseInterface;
use SetCMS\Module\User\Entity\UserEntity;

abstract class View extends \UUA\View
{

    public UserEntity $currentUser;
    public SplObjectStorage $messages;
    public protected(set) ?ResponseInterface $response = null;
}
