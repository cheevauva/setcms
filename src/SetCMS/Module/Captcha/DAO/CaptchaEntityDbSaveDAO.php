<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\DAO;

class CaptchaEntityDbSaveDAO extends \SetCMS\Entity\DAO\EntitySaveDAO
{

    use \SetCMS\FactoryTrait;
    use CaptchaEntityDbDAOTrait;
}
