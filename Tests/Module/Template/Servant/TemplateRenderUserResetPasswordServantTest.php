<?php

declare(strict_types=1);

namespace Tests\Module\Template\Servant;

use Psr\Container\ContainerInterface;
use Module\Template\Servant\TemplateRenderUserResetPasswordServant;
use Module\User\Entity\UserEntity;
use Module\UserResetToken\Entity\UserResetTokenEntity;
use Module\Template\Entity\TemplateEntity;

class TemplateRenderUserResetPasswordServantTest extends \Tests\TestEasy
{

    public function testRender(): void
    {
        $userResetToken = new UserResetTokenEntity();

        $user = new UserEntity();
        $user->email = 'admin@admin';
        $user->username = 'admin';

        $render = TemplateRenderUserResetPasswordServant::new(self::$container);
        $render->user = $user;
        $render->userResetToken = $userResetToken;
        $render->serve();

        $this->assertEquals('admin, ваша ссылка для сброса пароля', $render->templateRendered->title);
        $this->assertEquals('admin, ваша ссылка для сброса пароля http://test.ru/user/resetPasswordByToken/' . $userResetToken->token, $render->templateRendered->content);
    }


    #[\Override]
    protected function mocks(ContainerInterface $c): array
    {
        return [
            'routes' => [
                'GET /user/resetPasswordByToken/[*:token] UserResetPasswordByToken' => \Module\User\Controller\UserPublicResetPasswordByTokenController::class,
            ],
            'env' => [
                'BASE_URL' => 'http://test.ru',
            ],
            TemplateRenderUserResetPasswordServant::class => fn() => new class($c) extends TemplateRenderUserResetPasswordServant {

                #[\Override]
                protected function template(): TemplateEntity
                {
                    $template = new TemplateEntity();
                    $template->slug = 'resetPassword';
                    $template->title = '{{ user.username }}, ваша ссылка для сброса пароля';
                    $template->template = "{{ user.username }}, ваша ссылка для сброса пароля {{ scBaseUrl() }}{{ scLink('UserResetPasswordByToken', {token: userResetToken.token}) }}";

                    return $template;
                }
            },
        ];
    }
}
