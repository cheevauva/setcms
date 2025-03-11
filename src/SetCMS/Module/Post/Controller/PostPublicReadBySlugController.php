<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Controller;

use SetCMS\Controller;
use SetCMS\Module\Post\DAO\PostRetrieveManyByCriteriaDAO;
use SetCMS\Module\Post\PostEntity;
use SetCMS\Attribute\Http\Parameter\Attributes;
use SetCMS\Attribute\ResponderPassProperty;

class PostPublicReadBySlugController extends Controller
{

    #[Attributes('slug')]
    public string $slug;

    #[ResponderPassProperty]
    protected ?PostEntity $post = null;

    #[\Override]
    protected function units(): array
    {
        return [
            PostRetrieveManyByCriteriaDAO::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostRetrieveManyByCriteriaDAO) {
            $object->slug = $this->slug;
            $object->orThrow = true;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PostRetrieveManyByCriteriaDAO) {
            $this->post = $object->post;
        }
    }
}
