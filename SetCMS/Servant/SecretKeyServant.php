<?php

declare(strict_types=1);

namespace SetCMS\Servant;

use SetCMS\Exception\SecretKeyException;

class SecretKeyServant extends \UUA\Servant
{

    use \UUA\Traits\EnvTrait;

    public string $secretKey;
    public string $secretKeyType;

    #[\Override]
    public function serve(): void
    {
        if (empty($this->env()[$this->secretKeyType])) {
            throw new SecretKeyException('Ключ не указан в окружении');
        }

        if ($this->env()[$this->secretKeyType] !== $this->secretKey) {
            throw new SecretKeyException('Ключ неверный');
        }
    }
}
