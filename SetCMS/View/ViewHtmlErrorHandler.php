<?php

declare(strict_types=1);

namespace SetCMS\View;

use SetCMS\View\ViewTwig;

class ViewHtmlErrorHandler extends ViewTwig
{
    #[\Override]
    protected function run(): void
    {
        if ($this->messages->count() === 0) {
            return;
        }
        
        parent::run();
    }
}
