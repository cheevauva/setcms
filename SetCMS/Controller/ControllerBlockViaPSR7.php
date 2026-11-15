<?php

declare(strict_types=1);

namespace SetCMS\Controller;

use SetCMS\Request\Mapper\RequestToRootContextMapper;
use SetCMS\DTO\RootContextDTO;

class ControllerBlockViaPSR7 extends ControllerViaPSR7
{

    protected RootContextDTO $rootContext;


    #[\Override]
    protected function overrideDomainUnits(array $domainUnits): array
    {
        return [
            RequestToRootContextMapper::class,
            ...$domainUnits
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof RequestToRootContextMapper) {
            $this->rootContext = $object->rootContext;
        }
    }
}
