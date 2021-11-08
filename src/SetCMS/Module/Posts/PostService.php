<?php

namespace SetCMS\Module\Posts;

use SetCMS\Module\Posts\PostDAO;
use SetCMS\Module\Posts\Post;
use SetCMS\Module\Posts\PostModel\PostModelRead;
use SetCMS\Module\Ordinary\OrdinaryService;

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

    public function readBySlug(PostModelRead $model): void
    {
        $model->entity($this->dao()->getBySlug($model->slug));
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
