<?php

declare(strict_types=1);

namespace SetCMS\Validation;

use SplObjectStorage;

class Validation
{

    public function __construct(protected array $data, protected SplObjectStorage $messages)
    {
        
    }

    public function uuid(string $path): UUID
    {
        return new UUID($this->data, $path, $this->messages);
    }

    public function array(string $path): Arr
    {
        return new Arr($this->data, $path, $this->messages);
    }

    public function string(string $path): Str
    {
        return new Str($this->data, $path, $this->messages);
    }

    public function bool(string $path): Bool
    {
        return new Bool($this->data, $path, $this->messages);
    }

    public function int(string $path): Int
    {
        return new Int($this->data, $path, $this->messages);
    }

    public function float(string $path): Float
    {
        return new Float($this->data, $path, $this->messages);
    }
}
