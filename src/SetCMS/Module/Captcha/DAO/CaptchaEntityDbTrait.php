<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\FactoryInterface;
use SetCMS\Module\Captcha\CaptchaEntityDbMapper;
use SetCMS\Module\Captcha\CaptchaConstants;
use SetCMS\Database\MainConnection;

trait CaptchaEntityDbTrait
{

    public function __construct(ContainerInterface $container)
    {
        $this->mapper = CaptchaEntityDbMapper::factory($container->get(FactoryInterface::class));
        $this->table = CaptchaConstants::TABLE_NAME;
        $this->db = $container->get(MainConnection::class);
    }

}
