<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Controller;

use SetCMS\UUID;
use SetCMS\Attribute\Http\Parameter\Query;
use SetCMS\Module\Captcha\Exception\CaptchaException;
use SetCMS\Module\Captcha\Servant\CaptchaResolveServant;
use SetCMS\Module\Captcha\DAO\CaptchaRetrieveManyByCriteriaDAO;
use SetCMS\Module\Captcha\DAO\CaptchaSaveDAO;
use SetCMS\Module\Captcha\CaptchaEntity;
use SetCMS\Attribute\Http\RequestMethod;
use SetCMS\Attribute\ResponderPassProperty;

#[RequestMethod('GET')]
class CaptchaPublicSolveController extends \SetCMS\Controller
{

    #[Query('id')]
    public UUID $id;

    #[Query('solvedText')]
    public string $solvedText;
    protected CaptchaEntity $captcha;

    #[ResponderPassProperty]
    protected ?bool $isSolved = null;

    #[ResponderPassProperty]
    protected ?bool $isUsed = null;

    #[\Override]
    protected function units(): array
    {
        return [
            CaptchaRetrieveManyByCriteriaDAO::class,
            CaptchaResolveServant::class,
            CaptchaSaveDAO::class,
        ];
    }

    #[\Override]
    public function to(object $object): void
    {
        parent::to($object);

        if ($object instanceof CaptchaRetrieveManyByCriteriaDAO) {
            $object->id = $this->id;
            $object->throwExceptionIfNotFound = true;
        }

        if ($object instanceof CaptchaResolveServant) {
            $object->captcha = CaptchaEntity::as($this->captcha);
            $object->solvedText = $this->solvedText;
        }

        if ($object instanceof CaptchaSaveDAO) {
            $object->captcha = CaptchaEntity::as($this->captcha);
        }
    }

    #[\Override]
    public function from(object $object): void
    {
        parent::from($object);

        if ($object instanceof CaptchaException) {
            $this->catchToMessage('id', $object);
        }

        if ($object instanceof CaptchaRetrieveManyByCriteriaDAO) {
            $this->captcha = CaptchaEntity::as($object->first);
        }

        if ($object instanceof CaptchaResolveServant) {
            $this->isSolved = $object->captcha->isSolved;
            $this->isUsed = $object->captcha->isUsed;
        }
    }
}
