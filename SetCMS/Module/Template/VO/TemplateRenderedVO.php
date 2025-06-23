<?php

declare(strict_types=1);

namespace SetCMS\Module\Template\VO;

class TemplateRenderedVO
{

    use \UUA\Traits\AsTrait;

    public string $title;
    public string $content;
}
