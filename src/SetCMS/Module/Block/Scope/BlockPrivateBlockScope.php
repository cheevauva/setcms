<?php

declare(strict_types=1);

namespace SetCMS\Module\Block\Scope;

use SetCMS\Module\Block\BlockEntity;
use SetCMS\UUID;

class BlockPrivateBlockScope extends BlockPrivateScope
{

    public UUID $id;
    public string $path;
    public string $params;
    public string $template;
    public string $section;

    public function satisfy(): \Iterator
    {
        parent::satisfy();

        if (0) {
            yield ['', ''];
        }
    }

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof BlockEntity) {
            $object->id = $this->id;
            $object->path = $this->path;
            $object->params = $this->params;
            $object->template = $this->template;
            $object->section = $this->section;
        }
    }

}
