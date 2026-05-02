<?php

declare(strict_types=1);

namespace SetCMS\View;

use SetCMS\View\ViewTwig;

class ViewHtmlErrorHandler extends ViewTwig
{
    #[\Override]
    public function serve(): void
    {
        if ($this->messages->count() === 0) {
            return;
        }
        
        parent::serve();
    }
}
