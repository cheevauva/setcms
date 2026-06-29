<?php

declare(strict_types=1);

namespace Module\Post\Mapper;

class PostToRowMapper extends \SetCMS\Entity\Mapper\EntityBasicToRowMapper
{

    use \Module\Post\Traits\PostCallTrait;

    #[\Override]
    public function serve(): void
    {
        $this->id($this->post);
        $this->basic($this->post);
        $this->row['slug'] = $this->post->slug;
        $this->row['title'] = $this->post->title;
        $this->row['message'] = $this->post->message;
    }
}
