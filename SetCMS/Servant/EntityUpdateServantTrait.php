<?php

declare(strict_types=1);

namespace SetCMS\Servant;

trait EntityUpdateServantTrait
{

    public ?\Throwable $throwIfNotExists = null;

    public function serve(): void
    {
        if (isset($this->throwIfNotExists) && !$this->hasById()) {
            throw $this->throwIfNotExists;
        }

        $this->update();
    }

    abstract protected function hasById(): bool;

    abstract protected function update(): void;
}
