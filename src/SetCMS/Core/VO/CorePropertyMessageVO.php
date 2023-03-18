<?php

declare(strict_types=1);

namespace SetCMS\Core\VO;

class CorePropertyMessageVO
{

    use \SetCMS\AsTrait;

    public string $message;
    public ?string $field = null;

    public function __construct(string $message, ?string $field = null)
    {
        $this->message = $message;
        $this->field = $field;
    }

    public static function fromArray(array $array): self
    {
        return new static($array[0], $array[1] ?? null);
    }

}
