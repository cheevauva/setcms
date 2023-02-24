<?php

namespace SetCMS;

interface ServerRequestAttribute
{

    public const ACCESS_TOKEN = 'X-CSRF-Token';
    public const CURRENT_USER = 'currentUser';

}
