<?php

namespace SetCMS\Module\Ordinary;

class OrdinaryEntity
{

    public ?int $id = null;
    public \DateTime $dateCreated;
    public \DateTime $dateModified;

    public function __construct()
    {
        $this->dateCreated = new \DateTime();
        $this->dateModified = new \DateTime();
    }

}
