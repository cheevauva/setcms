<?php

namespace SetCMS\Module\Pages;

use SetCMS\Module\Ordinary\OrdinaryDAO;
use SetCMS\Module\Pages\Page;
use SetCMS\Module\Pages\PageException;

class PageDAO extends OrdinaryDAO
{

    protected function entity2record(\SetCMS\Module\Ordinary\OrdinaryEntity $entity): array
    {
        assert($entity instanceof Page);

        return $this->ordinaryEntity2RecordBind($entity, [
            'content' => $entity->content,
            'title' => $entity->title,
            'slug' => $entity->slug,
        ]);
    }

    protected function getException(): PageException
    {
        return new PageException;
    }

    protected function getTableName(): string
    {
        return 'pages';
    }

    protected function record2entity(array $record): Page
    {
        $page = new Page;
        $page->content = $record['content'];
        $page->slug = $record['slug'];
        $page->title = $record['title'];

        return $this->ordinaryRecord2EntityBind($record, $page);
    }

}
