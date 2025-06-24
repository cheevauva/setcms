<?php

declare(strict_types=1);

namespace SetCMS\Module\Email\View;

use SetCMS\Module\Email\Entity\EmailEntity;

class EmailPrivateEditView extends EmailPrivateReadView
{

    public EmailEntity $email;
}
