<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\DAO;

use SetCMS\Module\Post\PostEntity;

class PostRetrieveManyByCriteriaDAO extends \SetCMS\Common\DAO\EntityRetrieveManyByCriteriaDAO
{

    use PostGenericDAO;

    public string $slug;
    public array $posts;
    public ?PostEntity $post = null;

    #[\Override]
    public function serve(): void
    {
        if (isset($this->slug)) {
            $this->criteria = [
                'slug' => $this->slug,
                'deleted' => 0,
            ];
            $this->limit = 1;
        }

        parent::serve();

        $this->posts = $this->entities;
        $this->post = $this->first;
    }
}
