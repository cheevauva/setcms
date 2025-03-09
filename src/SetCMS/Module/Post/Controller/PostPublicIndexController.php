<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Controller;

use SetCMS\Controller;
use SetCMS\Module\Post\DAO\PostRetrieveManyByCriteriaDAO;
use SetCMS\Attribute\ResponderPassProperty;
use SetCMS\Attribute\Http\RequestMethod;

#[RequestMethod('GET')]
class PostPublicIndexController extends Controller
{

    #[ResponderPassProperty]
    protected array $entities = [];

    #[\Override]
    protected function units(): array
    {
        return [
            PostRetrieveManyByCriteriaDAO::class,
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
}
