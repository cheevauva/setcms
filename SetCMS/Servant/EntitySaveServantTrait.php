<?php

declare(strict_types=1);

namespace SetCMS\Servant;

trait EntitySaveServantTrait
{

    public function serve(): void
    {
        if ($this->hasById()) {
            $this->update();
        } else {
            $this->create();
        }
    }

    abstract protected function hasById(): bool;

    abstract protected function update(): void;

    abstract protected function create(): void;
}
