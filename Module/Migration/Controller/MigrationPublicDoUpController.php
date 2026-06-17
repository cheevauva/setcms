<?php

declare(strict_types=1);

namespace Module\Migration\Controller;

use SetCMS\Controller\ControllerViaPSR7;
use Module\Migration\Servant\MigrationUpServant;
use Module\Migration\View\MigrationPublicDoUpView;
use Module\Migration\VO\MigrationCandidateVO;
use SetCMS\UseCase\SecretKey\Servant\SecretKeyServant;
use SetCMS\UseCase\SecretKey\Exception\SecretKeyWrongException;
use Module\Migration\Mapper\MigrationUpFromRequestMapper;

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
            MigrationUpFromRequestMapper::class,
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
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof MigrationUpServant) {
            foreach ($object->failded as $fail) {
                $fail = MigrationCandidateVO::as($fail);

                if (empty($fail->error)) {
                    continue;
                }

                $reflection = new \ReflectionClass($fail->error);
                $property = $reflection->getProperty('message');
                $property->setAccessible(true);
                $property->setValue($fail->error, sprintf('%s: %s', $fail->file, $fail->error->getMessage()));

                $this->messages->attach($fail->error, 'secretKey');
            }
        }

        if ($object instanceof MigrationUpFromRequestMapper) {
            $this->dbName = $object->dbName;
            $this->secretKey = $object->secretKey;
        }
    }

    #[\Override]
    protected function catch(\Throwable $object): void
    {
        parent::catch($object);

        if ($object instanceof SecretKeyWrongException) {
            $this->messages->attach($object, 'secretKey');
        }

        if ($object instanceof \RuntimeException) {
            $this->messages->attach($object, 'dbName');
        }
    }
}
