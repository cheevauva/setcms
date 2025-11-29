<?php

declare(strict_types=1);

namespace Tests\Template\Servant;

use Psr\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;
use Module\Template\Servant\TemplateRenderUserResetPasswordServant;
use Module\User\Entity\UserEntity;
use Module\UserResetToken\Entity\UserResetTokenEntity;
use Module\Template\Entity\TemplateEntity;

class TemplateRenderUserResetPasswordServantTest extends TestCase
{

    use \Tests\TestTrait;

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
        $this->assertEquals('admin, ваша ссылка для сброса пароля http://test.ru/user/resetPasswordByToken/' . $userResetToken->token, $render->templateRendered->content);
    }

    /**
     * @return \Closure
     */
    protected function mocks(): \Closure
    {
        return fn(ContainerInterface $container) => [
            'routes' => [
                'GET /user/resetPasswordByToken/[*:token] UserResetPasswordByToken' => \Module\User\Controller\UserPublicResetPasswordByTokenController::class,
            ],
            'env' => [
                'BASE_URL' => 'http://test.ru',
            ],
            TemplateRenderUserResetPasswordServant::class => fn($container) => new class($container) extends TemplateRenderUserResetPasswordServant {

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
