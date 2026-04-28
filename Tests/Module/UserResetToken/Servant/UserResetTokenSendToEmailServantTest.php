<?php

declare(strict_types=1);

namespace Tests\Module\UserResetToken\Servant;

use Psr\Container\ContainerInterface;
use PHPUnit\Framework\Attributes\Group;
use Module\UserResetToken\Servant\UserResetTokenSendToEmailServant;
use Module\UserResetToken\Servant\UserResetTokenSendToUserServant;
use Module\User\DAO\UserRetrieveManyByCriteriaDAO;
use Module\User\Entity\UserEntity;
use Module\UserResetToken\Entity\UserResetTokenEntity;

#[Group('User')]
#[Group('UserServant')]
class UserResetTokenSendToEmailServantTest extends \Tests\TestEasy
{

    public static ?UserEntity $user;

    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();

        self::$user = null;
    }

    public function testNotExistUser(): void
    {
        $sendToEmail = UserResetTokenSendToEmailServant::new(self::$container);
        $sendToEmail->email = 'admin1@admin';
        $sendToEmail->serve();

        self::assertEmpty($sendToEmail->email);
    }

    #[\Override]
    public function mocks(ContainerInterface $c): array
    {
        return [
            UserRetrieveManyByCriteriaDAO::class => fn() => new class($c) extends UserRetrieveManyByCriteriaDAO {

                #[\Override]
                public function serve(): void
                {
                    $this->userOrNull = UserResetTokenSendToEmailServantTest::$user;
                }
            },
            UserResetTokenSendToUserServant::class => fn() => new class($c) extends UserResetTokenSendToUserServant {

                #[\Override]
                public function serve(): void
                {
                    $this->userResetToken = new UserResetTokenEntity();
                }
            },
        ];
    }
}
