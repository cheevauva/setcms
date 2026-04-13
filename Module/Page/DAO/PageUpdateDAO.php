<?php

declare(strict_types=1);

namespace Module\Page\DAO;

use Psr\Container\ContainerInterface;
use Module\Page\Entity\PageEntity;
use Module\Page\Mapper\PageToRowMapper;

class PageUpdateDAO extends \UUA\DAO
{

    use \SetCMS\DAO\EntityUpdateDAOTrait;
    use PageCommonDAO;

    public PageEntity $page;

    #[\Override]
    protected function row(): array
    {
        return PageToRowMapper::call($this->container, $this->page)->row;
    }

    #[\Override]
    protected function id(): string
    {
        return (string) $this->page->id;
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
