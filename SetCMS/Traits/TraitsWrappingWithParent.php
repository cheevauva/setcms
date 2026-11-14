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

        $units = array_unique([
            ...class_implements($this),
            ...class_parents($this),
            $this::class,
        ]);

        $local = [];

        foreach ($units as $unit) {
            if (empty($wrappers[$unit])) {
                continue;
                
            }

            $local = array_merge($local, $wrappers[$unit]);
        }

        return $local;
    }

    /**
     * @return class-string
     */
    protected function unitNameForWrapping2(string $unitName): string
    {
        if (str_contains($unitName, '@anonymous')) {
            $unitName = get_parent_class($unitName);
        }

        // @phpstan-ignore-next-line
        return $unitName;
    }
}
