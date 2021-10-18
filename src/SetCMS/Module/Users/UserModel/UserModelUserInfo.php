<?php

namespace SetCMS\Module\Users\UserModel;

use SetCMS\Module\Ordinary\OrdinaryModel\OrdinaryModel;

class UserModelUserInfo extends OrdinaryModel
{

    public function toArray(): array
    {
        return get_object_vars($this->entity());
    }

}
