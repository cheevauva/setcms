<?php

declare(strict_types=1);

namespace SetCMS\Validation;

use SplObjectStorage;

class Validation
{

    /**
     * @param array<int|string, mixed> $data
     * @param \SplObjectStorage<\Throwable,string> $messages
     */
    public function __construct(protected array $data, protected SplObjectStorage $messages)
    {
        
    }

    public function object(string $path): Obj
    {
        return new Obj($this->data, $path, $this->messages);
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

    public function bool(string $path): Bln
    {
        return new Bln($this->data, $path, $this->messages);
    }

    public function int(string $path): Integer
    {
        return new Integer($this->data, $path, $this->messages);
    }

    public function float(string $path): Flt
    {
        return new Flt($this->data, $path, $this->messages);
    }
}
