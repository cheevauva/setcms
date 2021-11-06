<?php

namespace SetCMS\Module\Posts;

use SetCMS\Module\Posts\PostDAO;
use SetCMS\Module\Posts\Post;
use SetCMS\Module\Ordinary\OrdinaryService;
use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModelRead;
use SetCMS\Module\Posts\PostModel\PostModelRead;

class PostService extends OrdinaryService
{

    private PostDAO $dao;

    public function createFirstPost()
    {
        $post = new Post;
        $post->id = 1;
        $post->slug = 'hello_world';
        $post->title = 'SetCMS готова к использованию';
        $post->message = implode(PHP_EOL, [
            'Реквизиты администратора:',
            '',
            '- Пользователь:admin',
            '- Пароль: administrator',
            '',
            '*После входа обязательно смените пароль*',
        ]);

        $this->dao()->save($post);
    }

    public function read(OrdinaryModelRead $model): void
    {
        if ($model instanceof PostModelRead && $model->slug) {
            $entity = $this->dao()->getBySlug($model->slug);
        } else {
            $entity = $this->dao()->get($model->id);
        }

        $model->entity($entity);
    }

    public function __construct(PostDAO $dao)
    {
        $this->dao = $dao;
    }

    protected function dao(): PostDAO
    {
        return $this->dao;
    }

    public function entity(): Post
    {
        return new Post;
    }

}
