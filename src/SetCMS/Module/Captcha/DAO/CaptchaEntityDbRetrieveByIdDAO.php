<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\DAO;

use SetCMS\Module\Captcha\CaptchaEntity;

class CaptchaEntityDbRetrieveByIdDAO extends \SetCMS\Entity\DAO\EntityDbRetrieveByIdDAO
{

    use CaptchaEntityDbDAOTrait;
    
    public ?CaptchaEntity $captcha = null;

    public function serve(): void
    {
        parent::serve();
        
        $this->captcha = $this->entity;
    }

}
