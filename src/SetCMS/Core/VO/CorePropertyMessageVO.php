<?php

declare(strict_types=1);

namespace SetCMS\Core\VO;

class CorePropertyMessageVO
{

    use \SetCMS\AsTrait;

    public ?string $field = null;
    public string $message;

    public function __construct(?string $field, string $message)
    {
        $this->message = $message;
        $this->field = $field;
    }

    public static function fromArray(array $array): self
    {
        return new static($array[0], $array[1]);
    }

}
