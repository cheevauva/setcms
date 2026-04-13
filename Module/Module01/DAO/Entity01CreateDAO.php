<?php

declare(strict_types=1);

namespace Module\Module01\DAO;

use Psr\Container\ContainerInterface;
use Module\Module01\Entity\Entity01Entity;
use Module\Module01\Mapper\Entity01ToRowMapper;

class Entity01CreateDAO extends \UUA\DAO
{

    use \SetCMS\DAO\EntityCreateDAOTrait;
    use Entity01CommonDAO;

    public Entity01Entity $entity01;

    #[\Override]
    protected function row(): array
    {
        return Entity01ToRowMapper::call($this->container, $this->entity01)->row;
    }

    /**
     * @param ContainerInterface $container
     * @param Entity01Entity $entity01
     * @return static
     */
    public static function call(ContainerInterface $container, Entity01Entity $entity01): self
    {
        $self = self::new($container);
        $self->entity01 = $entity01;
        $self->serve();

        return $self;
    }
}
