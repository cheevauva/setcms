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

    public function __construct(ContainerInterface $container, FactoryInterface $factory)
    {
        $this->db = $container->get(MainConnection::class);
        $this->mapper = OAuthClientEntityDbMapper::make($factory);
        $this->table = OAuthClientContstants::TABLE_NAME;
    }

}
