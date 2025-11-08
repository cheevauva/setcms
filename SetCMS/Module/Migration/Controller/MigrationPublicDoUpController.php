<?php

declare(strict_types=1);

namespace SetCMS\Module\Migration\Controller;

use SetCMS\ControllerViaPSR7;
use SetCMS\Module\Migration\Servant\MigrationUpServant;
use SetCMS\Module\Migration\View\MigrationPublicDoUpView;
use SetCMS\Servant\SecretKeyServant;
use SetCMS\Exception\SecretKeyException;

class MigrationPublicDoUpController extends ControllerViaPSR7
{

    public bool $hasACLCheck = false;
    //
    protected string $dbName;
    protected string $secretKey;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            SecretKeyServant::class,
            MigrationUpServant::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            MigrationPublicDoUpView::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof SecretKeyServant) {
            $object->secretKey = $this->secretKey;
            $object->secretKeyType = 'SECRET_KEY_MIGRATION_UP';
        }

        if ($object instanceof MigrationUpServant) {
            $object->dbName = $this->dbName;
        }
    }

    #[\Override]
    protected function process(): void
    {
        $body = $this->request->getParsedBody() ?? [];

        $validation = $this->validation($body);

        $this->dbName = $validation->string('dbName')->notEmpty()->val();
        $this->secretKey = $validation->string('secretKey')->notEmpty()->val();
    }

    #[\Override]
    protected function catch(\Throwable $object): void
    {
        parent::catch($object);

        if ($object instanceof SecretKeyException) {
            $this->messages->attach($object, 'secretKey');
        }

        if ($object instanceof \RuntimeException) {
            $this->messages->attach($object, 'dbName');
        }
    }
}
