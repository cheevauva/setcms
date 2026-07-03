<?php

declare(strict_types=1);

namespace Module\RAD\Servant;

use Module\RAD\DAO\RADFileSaveDAO;

class RADGenerateAndCommitServant extends RADGenerateServant
{

    #[\Override]
    public function serve(): void
    {
        parent::serve();

        foreach ($this->files as $file) {
            $targetSave = RADFileSaveDAO::new($this->container);
            $targetSave->fileOrDir = $file;
            $targetSave->serve();
        }
    }
}
