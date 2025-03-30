<?php

declare(strict_types=1);

namespace SetCMS\Module\Post\View;

use SetCMS\View\ViewTwig;

class PostPublicNotFoundView extends ViewTwig
{

    #[\Override]
    public function serve(): void
    {
        if (!$this->messages->valid()) {
            return;
        }

        while ($this->messages->valid()) {
            var_dump(get_class($this->messages->current()));
            die;

            $this->messages->next();
        }

        parent::serve();
    }
}
