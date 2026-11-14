<?php

declare(strict_types=1);

namespace Module\RAD\Servant;

use Module\RAD\DAO\RADFileSaveDAO;

class RADGenerateAndCommitServant extends RADGenerateServant
{

    #[\Override]
    protected function run(): void
    {
        parent::run();

        foreach ($this->files as $file) {
            $targetSave = RADFileSaveDAO::new($this);
            $targetSave->fileOrDir = $file;
            $targetSave->serve();
        }
    }
}
