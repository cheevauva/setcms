<?php

namespace SetCMS\Module;

use SetCMS\Module\Module;
use SetCMS\Module\Modules\Contract\ModuleIndexInterface;
use SetCMS\Module\OAuth\OAuthIndex;

class OAuth extends Module implements ModuleIndexInterface
{

    public function getName(): string
    {
        return 'OAuth';
    }

    public function getIndexControllerClassName(): string
    {
        return OAuthIndex::class;
    }

}
