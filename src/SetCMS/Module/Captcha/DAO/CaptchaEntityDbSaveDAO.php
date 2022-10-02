<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\DAO;

class CaptchaEntityDbSaveDAO extends \SetCMS\Entity\DAO\EntityDbSaveDAO
{

    use \SetCMS\FactoryTrait;
    use CaptchaEntityDbTrait;
}
