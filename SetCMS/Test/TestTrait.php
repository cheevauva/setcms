<?php

declare(strict_types=1);

namespace SetCMS\Test;

use Psr\Container\ContainerInterface;
use SetCMS\Bootstrap;

trait TestTrait
{

    protected function container(): ContainerInterface
    {
        $container = Bootstrap::instance()->newContainer();

        $customContainer = new class($container) implements ContainerInterface {

            /**
             * @var array<string, mixed>
             */
            public array $alias = [];

            public function __construct(protected ContainerInterface $container)
            {
                
            }

            #[\Override]
            public function get(string $id): mixed
            {
                if ($id === 'fake') {
                    return $this->alias;
                }

                return $this->container->get($id);
            }

            #[\Override]
            public function has(string $id): bool
            {
                if (isset($this->alias[$id])) {
                    return true;
                }

                return $this->container->has($id);
            }
        };

        $customContainer->alias = $this->alias($customContainer);

        return $customContainer;
    }

    /**
     * @param ContainerInterface $container
     * @return array<string, mixed>
     */
    protected function alias(ContainerInterface $container): array
    {
        return [];
    }
}
