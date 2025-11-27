<?php

declare(strict_types=1);

namespace Module\Page\Controller;

use Module\Page\Entity\PageEntity;
use Module\Page\DAO\PageRetrieveManyByCriteriaDAO;
use Module\Page\View\PagePublicReadView;
use Module\Page\Exception\PageNotFoundException;

class PagePublicReadBySlugController extends \SetCMS\Controller\ControllerViaPSR7
{

    protected string $slug;
    protected PageEntity $page;

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PageRetrieveManyByCriteriaDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            PagePublicReadView::class,
        ];
    }

    #[\Override]
    protected function process(): void
    {

        $this->slug = $this->validation($this->params)->string('slug')->notEmpty()->notQuiet()->val();
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PageRetrieveManyByCriteriaDAO) {
            $object->slug = $this->slug;
            $object->limit = 1;
        }

        if ($object instanceof PagePublicReadView) {
            $object->page = $this->page;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PageRetrieveManyByCriteriaDAO) {
            $this->page = $object->first ?? throw new PageNotFoundException();
        }
    }
}
