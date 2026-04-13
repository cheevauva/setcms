<?php

declare(strict_types=1);

namespace SetCMS\Servant;

trait EntityCreateServantTrait
{

    public ?\Throwable $throwIfNotExists = null;

    #[\Override]
    public function serve(): void
    {
        if (isset($this->throwIfNotExists) && !$this->hasById()) {
            throw $this->throwIfNotExists;
        }

        $this->create();
    }

    abstract protected function hasById(): bool;

    abstract protected function create(): void;
}
