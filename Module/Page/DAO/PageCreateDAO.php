<?php

declare(strict_types=1);

namespace Module\Page\DAO;

use Psr\Container\ContainerInterface;
use Module\Page\Entity\PageEntity;
use Module\Page\Mapper\PageToRowMapper;
use Module\Page\PageConstrants;

class PageCreateDAO extends \UUA\DAO
{

    use \SetCMS\Traits\DatabaseMainTrait;
    use \SetCMS\DAO\EntityCreateDAOTrait;

    public PageEntity $page;

    #[\Override]
    protected function table(): string
    {
        return PageConstrants::TABLE_NAME;
    }

    #[\Override]
    protected function row(): array
    {
        return PageToRowMapper::call($this->container, $this->page)->row;
    }

    /**
     * @param ContainerInterface $container
     * @param PageEntity $page
     * @return static
     */
    public static function call(ContainerInterface $container, PageEntity $page): self
    {
        $self = self::new($container);
        $self->page = $page;
        $self->serve();

        return $self;
    }
}
