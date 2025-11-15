<?php

declare(strict_types=1);

namespace Module\Email\View;

use Module\Email\Entity\EmailEntity;

class EmailPrivateEditView extends EmailPrivateReadView
{

    public EmailEntity $email;
}
