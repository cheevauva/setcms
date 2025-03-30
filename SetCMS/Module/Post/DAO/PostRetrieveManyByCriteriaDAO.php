<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\DAO;

use SetCMS\Module\Post\PostEntity;

class PostRetrieveManyByCriteriaDAO extends \SetCMS\Common\DAO\Entity\EntityRetrieveManyByCriteriaDAO
{

    use PostGenericDAO;

    public string $slug;
    public ?PostEntity $post;

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

        $this->post = $this->first;
    }
}
