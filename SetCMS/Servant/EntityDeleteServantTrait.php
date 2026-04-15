<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use SetCMS\Entity\Entity;
use SetCMS\UUID;

trait EntityDeleteServantTrait
{

    public UUID $id;
    public ?\Throwable $throwIfNotExists = null;
    public bool $safeDelete = true;

    #[\Override]
    public function serve(): void
    {
        $this->entity();

        if ($this->safeDelete) {
            $this->entity()->deleted = true;
            $this->update();
        } else {
            $this->delete();
        }
    }

    abstract protected function entity(): Entity;

    abstract protected function update(): void;

    abstract protected function delete(): void;
}
