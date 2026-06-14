<?php

declare(strict_types=1);

namespace SetCMS\UseCase\SecretKey\Servant;

use SetCMS\UseCase\SecretKey\Exception\SecretKeyTypeIndefinedException;
use SetCMS\UseCase\SecretKey\Exception\SecretKeyWrongException;

class SecretKeyServant extends \UUA\Servant
{

    use \UUA\Traits\EnvTrait;

    public string $secretKey;
    public string $secretKeyType;

    #[\Override]
    public function serve(): void
    {
        $secretKey = ($this->env()[$this->secretKeyType] ?? null) ?: throw new SecretKeyTypeIndefinedException(sprintf('Ключ "%s" не указан в окружении', $this->secretKeyType));

        if ($secretKey !== $this->secretKey) {
            throw new SecretKeyWrongException('Ключ неверный');
        }
    }
}
