<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthUser\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\FactoryInterface;
use SetCMS\Module\OAuth\OAuthUser\DAO\OAuthUserEntityDbMapper;
use SetCMS\Database\MainConnection;
use SetCMS\Module\OAuth\OAuthUser\OAuthUserContstants;

trait OAuthUserEntityDbTrait
{

    private FactoryInterface $factory;

    public function __construct(ContainerInterface $container)
    {
        $this->factory = $container->get(FactoryInterface::class);
        $this->db = $container->get(MainConnection::class);
        $this->mapper = OAuthUserEntityDbMapper::factory($this->factory);
        $this->table = OAuthUserContstants::TABLE_NAME;
    }

}
