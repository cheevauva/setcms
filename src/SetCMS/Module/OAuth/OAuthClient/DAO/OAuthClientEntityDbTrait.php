<?php

declare(strict_types=1);

namespace SetCMS\Module\OAuth\OAuthClient\DAO;

use Psr\Container\ContainerInterface;
use SetCMS\FactoryInterface;
use SetCMS\Database\MainConnection;
use SetCMS\Module\OAuth\OAuthClient\DAO\OAuthClientEntityDbMapper;
use SetCMS\Module\OAuth\OAuthClient\OAuthClientContstants;

trait OAuthClientEntityDbTrait
{

    use \SetCMS\FactoryTrait;

    private FactoryInterface $factory;

    public function __construct(ContainerInterface $container)
    {
        $this->factory = $container->get(FactoryInterface::class);
        $this->db = $container->get(MainConnection::class);
        $this->mapper = OAuthClientEntityDbMapper::factory($this->factory);
        $this->table = OAuthClientContstants::TABLE_NAME;
    }

}
