<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\DAO;

class CaptchaEntityDbRetrieveByIdDAO extends \SetCMS\Entity\DAO\EntityDbRetrieveByIdDAO
{

    use \SetCMS\FactoryTrait;
    use CaptchaEntityDbDAOTrait;
}
