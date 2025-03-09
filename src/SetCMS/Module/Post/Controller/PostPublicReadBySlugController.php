<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\Controller;

use SetCMS\Controller;
use SetCMS\Module\Post\DAO\PostRetrieveBySlugDAO;
use SetCMS\Module\Post\PostEntity;
use SetCMS\Attribute\Http\Parameter\Attributes;
use SetCMS\Attribute\ResponderPassProperty;

class PostPublicReadBySlugController extends Controller
{

    #[Attributes('slug')]
    public string $slug;

    #[ResponderPassProperty]
    private ?PostEntity $post = null;

    #[\Override]
    protected function units(): array
    {
        return [
            PostRetrieveBySlugDAO::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof PostRetrieveBySlugDAO) {
            $object->slug = $this->slug;
            $object->throwExceptionIfNotFound = true;
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof PostRetrieveBySlugDAO) {
            $this->post = $object->post;
        }
    }
}
