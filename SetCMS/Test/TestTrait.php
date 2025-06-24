<?php

declare(strict_types=1);

namespace SetCMS\Test;

use Psr\Container\ContainerInterface;
use UUA\Container\Container;

trait TestTrait
{

    protected function container(\Closure $mocks): ContainerInterface
    {
        $customContainer = new class([]) extends Container {

            /**
             * @var array<string, mixed>
             */
            public array $mocks = [];

            #[\Override]
            public function get(string $id): mixed
            {
                if ($id === 'fake') {
                    return $this->mocks;
                }

                if (isset($this->mocks[$id]) && !isset($this->assets[$id])) {
                    $this->assets[$id] = $this->mocks[$id];
                }

                return parent::get($id);
            }

            #[\Override]
            public function has(string $id): bool
            {
                if (isset($this->mocks[$id])) {
                    return true;
                }

                return parent::has($id);
            }
        };

        $customContainer->mocks = $mocks($customContainer);

        return $customContainer;
    }
    
}
