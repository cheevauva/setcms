<?php

declare(strict_types=1);

namespace SetCMS\Test;

use Psr\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;
use SetCMS\Module\Template\Servant\TemplateRenderUserResetPasswordServant;
use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Module\UserResetToken\Entity\UserResetTokenEntity;
use SetCMS\Module\Template\Entity\TemplateEntity;

class TemplateRenderUserResetPasswordTest extends TestCase
{

    use TestTrait;

    public function testRender(): void
    {
        $userResetToken = new UserResetTokenEntity();

        $user = new UserEntity();
        $user->email = 'admin@admin';
        $user->username = 'admin';

        $render = TemplateRenderUserResetPasswordServant::new($this->container($this->mocks()));
        $render->user = $user;
        $render->userResetToken = $userResetToken;
        $render->serve();

        $this->assertEquals('admin, ваша ссылка для сброса пароля', $render->templateRendered->title);
        $this->assertEquals('admin, ваша ссылка для сброса пароля http://test.ru/user/resetPassword/' . $userResetToken->token, $render->templateRendered->content);
    }

    /**
     * @return \Closure
     */
    protected function mocks(): \Closure
    {
        return fn(ContainerInterface $container) => [
            'routes' => [
                'GET /user/resetPassword/[a:token] UserResetPassword' => \SetCMS\Module\User\Controller\UserPublicResetPasswordController::class,
            ],
            'env' => [
                'BASE_URL' => 'http://test.ru',
            ],
            TemplateRenderUserResetPasswordServant::class => new class($container) extends TemplateRenderUserResetPasswordServant {

                #[\Override]
                protected function template(): TemplateEntity
                {
                    $template = new TemplateEntity();
                    $template->slug = 'resetPassword';
                    $template->title = '{{ user.username }}, ваша ссылка для сброса пароля';
                    $template->template = "{{ user.username }}, ваша ссылка для сброса пароля {{ scBaseUrl() }}{{ scLink('UserResetPassword', {token: userResetToken.token}) }}";

                    return $template;
                }
            },
        ];
    }
}
