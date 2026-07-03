<?php

declare(strict_types=1);

namespace Module\Page\Entity;

class PageEntity extends \Module\Basic\Entity\BasicEntity
{

    public string $slug;
    public string $title;
    public string $content;
}
