<?php

namespace SetCMS\Module\Ordinary;

class OrdinaryEntity
{

    public string $id;
    public \DateTime $dateCreated;
    public \DateTime $dateModified;

    public function __construct()
    {
        $this->id = sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
        $this->dateCreated = new \DateTime();
        $this->dateModified = new \DateTime();
    }

}
