<?php

declare(strict_types=1);

namespace Tests\Module\UserResetToken\Servant;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use SetCMS\UUID;
use Module\User\DAO\UserRetrieveManyByCriteriaDAO;
use Module\User\Entity\UserEntity;
use Module\UserResetToken\Servant\UserResetTokenSendToUserServant;
use Module\UserResetToken\Servant\UserResetTokenSendToEmailServant;
use Module\UserResetToken\Entity\UserResetTokenEntity;
use Module\UserResetToken\DAO\UserResetTokenRetrieveManyByCriteriaDAO;
use Module\UserResetToken\DAO\UserResetTokenSaveDAO;
use Module\Template\Servant\TemplateRenderUserResetPasswordServant;
use Module\Template\VO\TemplateRenderedVO;
use Module\Email\Servant\EmailSendServant;
use Module\Email\Entity\EmailEntity;

class UserResetTokenSendTest extends TestCase
{

    use \Tests\TestTrait;

    public static string $userId = '4c751162-8b67-4f22-b431-ed24c17f0048';
    public static string $userResetToken = '2b9d1c09-b417-43f5-bd7b-5b4db4dd6620';
    public static bool $userResetTokenRefreshExists = false;
    public static string $userResetTokenId = '4662e5e9-7f55-42ad-afe5-0fb50b7c37ce';
    public static ?UserResetTokenEntity $userResetTokenSaved = null;
    public static ?UserResetTokenEntity $userResetTokenRetrived = null;
    public static ?EmailEntity $sendedEmail = null;

    public function testNotExistUser(): void
    {
        UserResetTokenSendTest::$userResetTokenRefreshExists = true;
        UserResetTokenSendTest::$userResetTokenRetrived = null;
        UserResetTokenSendTest::$userResetTokenSaved = null;

        $sendToEmail = UserResetTokenSendToEmailServant::new($this->container($this->mocks()));
        $sendToEmail->email = 'admin1@admin';
        $sendToEmail->serve();

        $this->assertEmpty(UserResetTokenSendTest::$userResetTokenSaved);
    }

    public function testExistUserRefreshCases(): void
    {
        UserResetTokenSendTest::$userResetTokenRefreshExists = true;
        UserResetTokenSendTest::$userResetTokenRetrived = null;
        UserResetTokenSendTest::$userResetTokenSaved = null;
        UserResetTokenSendTest::$sendedEmail = null;

        $sendToUser = UserResetTokenSendToUserServant::new($this->container($this->mocks()));
        $sendToUser->user = self::newUser();
        $sendToUser->serve();

        $this->assertEquals(UserResetTokenSendTest::$userResetTokenRetrived, UserResetTokenSendTest::$userResetTokenSaved);
        $this->assertEquals((new \DateTime('+120 seconds'))->format('Y-m-d H:i:s'), UserResetTokenEntity::as(UserResetTokenSendTest::$userResetTokenSaved)->dateExpired->format('Y-m-d H:i:s'));

        $sendedEmail = EmailEntity::as(self::$sendedEmail);

        $this->assertEquals('test@test', $sendedEmail->from);
        $this->assertEquals('admin@admin', $sendedEmail->to);
        $this->assertEquals(UserResetTokenSendTest::$userId, $sendedEmail->subject);
        $this->assertEquals(UserResetTokenSendTest::$userResetTokenId, $sendedEmail->body);

        UserResetTokenSendTest::$userResetTokenRefreshExists = false;
        UserResetTokenSendTest::$userResetTokenRetrived = null;
        UserResetTokenSendTest::$userResetTokenSaved = null;
        UserResetTokenSendTest::$sendedEmail = null;

        $sendToUser2 = UserResetTokenSendToUserServant::new($this->container($this->mocks()));
        $sendToUser2->user = self::newUser();
        $sendToUser2->serve();

        $this->assertNotEquals(UserResetTokenSendTest::$userResetTokenRetrived, UserResetTokenSendTest::$userResetTokenSaved);

        $sendedEmail2 = EmailEntity::as(self::$sendedEmail);

        $this->assertEquals('test@test', $sendedEmail2->from);
        $this->assertEquals('admin@admin', $sendedEmail2->to);
        $this->assertEquals(UserResetTokenSendTest::$userId, $sendedEmail2->subject);
        $this->assertNotEquals(UserResetTokenSendTest::$userResetTokenId, $sendedEmail2->body);
    }

    public static function newUser(): UserEntity
    {
        $user = new UserEntity();
        $user->id = new UUID(UserResetTokenSendTest::$userId);
        $user->email = 'admin@admin';

        return $user;
    }

    public static function existsUserResetToken(): UserResetTokenEntity
    {
        $userResetToken = new UserResetTokenEntity();
        $userResetToken->id = new UUID(UserResetTokenSendTest::$userResetTokenId);
        $userResetToken->token = UserResetTokenSendTest::$userResetToken;
        $userResetToken->userId = new UUID(UserResetTokenSendTest::$userId);

        return $userResetToken;
    }

    public function mocks(): \Closure
    {
        return fn(ContainerInterface $container) => [
            'env' => [
                'EMAIL_ADDRESS_FOR_SENDING_SERVICE_MESSAGES' => 'test@test',
                'USER_RESET_TOKEN_REFRESH_EXISTS' => UserResetTokenSendTest::$userResetTokenRefreshExists,
                'USER_RESET_TOKEN_EXPIRED_SECONDS' => 120,
            ],
            EmailSendServant::class => fn($container) => new class($container) extends EmailSendServant {

                #[\Override]
                public function serve(): void
                {
                    UserResetTokenSendTest::$sendedEmail = $this->email;
                }
            },
            TemplateRenderUserResetPasswordServant::class => fn($container) => new class($container) extends TemplateRenderUserResetPasswordServant {

                #[\Override]
                public function serve(): void
                {
                    $this->templateRendered = new TemplateRenderedVO();
                    $this->templateRendered->title = $this->user->id->uuid;
                    $this->templateRendered->content = $this->userResetToken->id->uuid;
                }
            },
            UserResetTokenSaveDAO::class => fn($container) => new class($container) extends UserResetTokenSaveDAO {

                #[\Override]
                public function serve(): void
                {
                    UserResetTokenSendTest::$userResetTokenSaved = $this->userResetToken;
                }
            },
            UserResetTokenRetrieveManyByCriteriaDAO::class => fn($container) => new class($container) extends UserResetTokenRetrieveManyByCriteriaDAO {

                #[\Override]
                public function serve(): void
                {
                    if ($this->userId->uuid === UserResetTokenSendTest::$userId) {
                        $this->userResetToken = UserResetTokenSendTest::existsUserResetToken();
                        $this->userResetTokens = [$this->userResetToken];

                        UserResetTokenSendTest::$userResetTokenRetrived = $this->userResetToken;
                    }
                }
            },
            UserRetrieveManyByCriteriaDAO::class => fn($container) => new class($container) extends UserRetrieveManyByCriteriaDAO {

                #[\Override]
                public function serve(): void
                {
                    if ($this->email === 'admin@admin') {
                        $this->user = UserResetTokenSendTest::newUser();
                        $this->users = [$this->user];
                    }
                }
            },
        ];
    }
}
