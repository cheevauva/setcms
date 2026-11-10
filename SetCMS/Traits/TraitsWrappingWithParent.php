<?php

declare(strict_types=1);

namespace SetCMS\Traits;

trait TraitsWrappingWithParent
{

    use \UUA\Traits\WrappingTrait;

    /**
     * @return array<class-string>
     */
    protected function wrappers(): array
    {
        /** @var array<class-string, array<class-string>> $wrappers */
        $wrappers = $this->container->get('wrappers');

        return [
            ...$wrappers[self::class] ?? [],
            ...$wrappers[$this->unitNameForWrapping()] ?? []
        ];
    }
}
