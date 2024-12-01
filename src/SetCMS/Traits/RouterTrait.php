<?php

declare(strict_types=1);

namespace SetCMS\Traits;

trait RouterTrait
{

    /**
     * Creating adapter, using for create target route
     * 
     * @return static
     */
    public static function toRoute()
    {
        $controller = static::class;

        return new class($controller) {

            protected string $controller;

            public function __construct(string $controller)
            {
                $this->controller = $controller;
            }

            public function __call($name, $arguments)
            {
                unset($arguments);

                return sprintf('%s::%s', $this->controller, $name);
            }
        };
    }

}
