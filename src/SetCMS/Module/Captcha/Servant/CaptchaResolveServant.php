<?php

declare(strict_types=1);

namespace SetCMS\Module\Captcha\Servant;

use Psr\Container\ContainerInterface;
use SetCMS\Contract\Factory;
use SetCMS\Module\Captcha\DAO\CaptchaEntityDbRetrieveByIdDAO;
use SetCMS\Module\Captcha\DAO\CaptchaEntityDbSaveDAO;
use SetCMS\UUID;
use SetCMS\Module\Captcha\CaptchaEntity;

class CaptchaResolveServant implements \SetCMS\Contract\Servant
{

    protected Factory $factory;
    public UUID $id;
    public string $solvedText;
    public ?CaptchaEntity $captcha = null;

    public function __construct(ContainerInterface $container)
    {
        $this->factory = $container->get(Factory::class);
    }

    public function serve(): void
    {
        $retrieveById = CaptchaEntityDbRetrieveByIdDAO::make($this->factory);
        $retrieveById->id = $this->id;
        $retrieveById->serve();

        $this->solve($retrieveById->entity);

        $saveCaptcha = CaptchaEntityDbSaveDAO::make($this->factory);
        $saveCaptcha->entity = $retrieveById->entity;
        $saveCaptcha->serve();

        $this->captcha = $retrieveById->entity;
    }

    private function solve(CaptchaEntity $captcha): void
    {
        $captcha->solve($this->solvedText);
    }

}
