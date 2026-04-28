<?php

declare(strict_types=1);

namespace Tests\Module\UserResetToken\Servant;

use PHPUnit\Framework\Attributes\Group;
use Psr\Container\ContainerInterface;
use Module\UserResetToken\Servant\UserResetTokenSendToUserServant;
use Module\UserResetToken\DAO\UserResetTokenRetrieveManyByCriteriaDAO;
use Module\UserResetToken\Servant\UserResetTokenSaveServant;
use Module\Template\Servant\TemplateRenderUserResetPasswordServant;
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
        $sendToUser = UserResetTokenSendToUserServant::new(self::$container);
        $sendToUser->user = new UserEntity;
        $sendToUser->serve();
    }

    #[\Override]
    public function mocks(ContainerInterface $c): array
    {
        return array_merge(parent::mocks($c), [
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
                    
                }
            },
            EmailSendServant::class => fn() => new class($c) extends EmailSendServant {

                #[\Override]
                public function serve(): void
                {
                    
                }
            },
        ]);
    }
}
