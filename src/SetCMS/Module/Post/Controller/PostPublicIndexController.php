<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Controller;

use SetCMS\Controller;
use SetCMS\Module\Post\DAO\PostRetrieveManyByCriteriaDAO;
use SetCMS\Attribute\Http\RequestMethod;
use SetCMS\Module\Post\View\PostPublicIndexView;
use SetCMS\Module\Post\PostEntity;

#[RequestMethod('GET')]
class PostPublicIndexController extends Controller
{

    /**
     * @var PostEntity[]
     */
    protected array $entities = [];

    #[\Override]
    protected function domainUnits(): array
    {
        return [
            PostRetrieveManyByCriteriaDAO::class,
        ];
    }

    #[\Override]
    protected function viewUnits(): array
    {
        return [
            PostPublicIndexView::class,
        ];
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PostRetrieveManyByCriteriaDAO) {
            $this->entities = $object->entities;
        }
    }
    
    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);
        
        if ($object instanceof PostPublicIndexView) {
            $object->entities = $this->entities;
        }
    }
}
