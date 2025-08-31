<?php

declare(strict_types=1);

namespace UUA;

class Factory implements FactoryInterface
{

    /**
     * @var array<string, string|\Closure|null>
     */
    protected array $assets;

    use Traits\ContainerTrait;

    protected function init(): void
    {
        $this->assets = $this->container->get(spl_object_hash($this->container));
    }

    #[\Override]
    public function make(string $id): object
    {
        $this->assets[$id] ??= null;

        $isClosure = $this->assets[$id] instanceof \Closure;
        $isClassName = !$isClosure && is_string($this->assets[$id]) && class_exists($this->assets[$id], true);

        if (!empty($this->assets[$id]) && !$isClassName && !$isClosure) {
            throw new \Exception(sprintf('Инстанс класса %s уже был cоздан, возможно стоит использовать анонимную функцию', $id));
        }

        if ($this->assets[$id] instanceof \Closure) {
            $object = ($this->assets[$id])($this->container);

            if (!is_object($object)) {
                throw new \Exception(sprintf('Ожидался объект инстанс класса %s', $id));
            }

            return $object;
        }

        if ($isClassName) {
            return (new $this->assets[$id])($this->container);
        }

        return new $id($this->container);
    }
}
