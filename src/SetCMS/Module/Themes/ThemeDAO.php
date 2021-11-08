<?php

namespace SetCMS\Module\Themes;

use SetCMS\Module\Themes\Theme;

class ThemeDAO
{

    public function get(string $themeName): Theme
    {
        return new Theme($themeName);
    }

}
