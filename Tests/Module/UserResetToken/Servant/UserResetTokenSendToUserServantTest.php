<?php

declare(strict_types=1);

namespace Tests\Module\UserResetToken\Servant;

use PHPUnit\Framework\Attributes\Group;
use Psr\Container\ContainerInterface;
use Module\UserResetToken\Servant\UserResetTokenSendToUserServant;
use Module\UserResetToken\DAO\UserResetTokenRetrieveManyByCriteriaDAO;
use Module\UserResetToken\Servant\UserResetTokenSaveServant;
use Module\Template\Servant\TemplateRenderUserResetPasswordServant;
use Module\Template\VO\TemplateRenderedVO;
use Module\Email\Servant\EmailSendServant;
use Module\User\Entity\UserEntity;
use Module\UserResetToken\Entity\UserResetTokenEntity;

#[Group('User')]
#[Group('UserServant')]
class UserResetTokenSendToUserServantTest extends \Tests\TestEasy
{

    public static ?UserResetTokenEntity $userResetToken;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        self::$userResetToken = null;
    }

    public function testMain(): void
    {
        self::$env['EMAIL_ADDRESS_FOR_SENDING_SERVICE_MESSAGES'] = 'test@test';
        
        $user = new UserEntity;
        $user->email = 'email@email';

        $sendToUser = UserResetTokenSendToUserServant::new(self::$container);
        $sendToUser->user = $user;
        $sendToUser->serve();
    }

    #[\Override]
    public function mocks(ContainerInterface $c): array
    {
        return [
            UserResetTokenRetrieveManyByCriteriaDAO::class => fn() => new class($c) extends UserResetTokenRetrieveManyByCriteriaDAO {

                #[\Override]
                public function serve(): void
                {
                    
                }
            },
            UserResetTokenSaveServant::class => fn() => new class($c) extends UserResetTokenSaveServant {

                #[\Override]
                public function serve(): void
                {
                    
                }
            },
            TemplateRenderUserResetPasswordServant::class => fn() => new class($c) extends TemplateRenderUserResetPasswordServant {

                #[\Override]
                public function serve(): void
                {
                    $this->templateRendered = new TemplateRenderedVO;
                    $this->templateRendered->content = 'content';
                    $this->templateRendered->title = 'title';
                }
            },
            EmailSendServant::class => fn() => new class($c) extends EmailSendServant {

                #[\Override]
                public function serve(): void
                {
                    
                }
            },
        ];
    }
}
