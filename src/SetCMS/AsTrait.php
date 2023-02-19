<?php

declare(strict_types=1);

namespace SetCMS;

trait AsTrait
{

    public static function as(self $self): self
    {
        return $self;
    }
    
}
