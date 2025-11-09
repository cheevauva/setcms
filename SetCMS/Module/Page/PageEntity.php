<?php

declare(strict_types=1);

namespace SetCMS\Module\Page;

use SetCMS\Common\Entity\Entity;
use SetCMS\UUID;

class PageEntity extends Entity
{

    public string $slug;
    public string $title;
    public string $content;
    public UUID $createdUserId;
}
