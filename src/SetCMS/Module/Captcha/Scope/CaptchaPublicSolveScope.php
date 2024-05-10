<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Scope;

use SetCMS\UUID;
use SetCMS\Attribute\Http\Parameter\Query;
use SetCMS\Attribute\NotBlank;
use SetCMS\Module\Captcha\Exception\CaptchaException;
use SetCMS\Module\Captcha\Servant\CaptchaResolveServant;
use SetCMS\Module\Captcha\DAO\CaptchaRetrieveByIdDAO;
use SetCMS\Module\Captcha\DAO\CaptchaSaveDAO;
use SetCMS\Module\Captcha\CaptchaEntity;

class CaptchaPublicSolveScope extends \SetCMS\Scope
{

    #[Query('id')]
    public UUID $id;

    #[Query('solvedText')]
    public string $solvedText;
    //
    private ?CaptchaEntity $captcha = null;

    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof CaptchaRetrieveByIdDAO) {
            $object->id = $this->id;
            $object->throwExceptionIfNotFound = true;
        }

        if ($object instanceof CaptchaResolveServant) {
            $object->captcha = $this->captcha;
            $object->solvedText = $this->solvedText;
        }

        if ($object instanceof CaptchaSaveDAO) {
            $object->captcha = $this->captcha;
        }
    }

    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof CaptchaException) {
            $this->catchToMessage('id', $object);
        }

        if ($object instanceof CaptchaRetrieveByIdDAO) {
            $this->captcha = $object->captcha;
        }
    }

    public function toArray(): array
    {
        if (!$this->captcha) {
            return [];
        }

        return [
            'isSolved' => $this->captcha->isSolved,
            'isUsed' => $this->captcha->isUsed,
        ];
    }

}
