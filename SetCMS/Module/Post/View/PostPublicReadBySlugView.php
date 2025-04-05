<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\View;

use SetCMS\View\ViewTwig;
use SetCMS\Module\Post\PostEntity;
use SetCMS\Module\User\Entity\UserEntity;

class PostPublicReadBySlugView extends ViewTwig
{

    public PostEntity $post;
    public UserEntity $currentUser;
}
