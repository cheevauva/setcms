<?php

declare(strict_types=1);

namespace SetCMS\Test;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use SetCMS\UUID;
use SetCMS\Module\User\DAO\UserRetrieveManyByCriteriaDAO;
use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Module\UserResetToken\Servant\UserResetTokenSendToUserServant;
use SetCMS\Module\UserResetToken\Servant\UserResetTokenSendToEmailServant;
use SetCMS\Module\UserResetToken\Entity\UserResetTokenEntity;
use SetCMS\Module\UserResetToken\DAO\UserResetTokenRetrieveManyByCriteriaDAO;
use SetCMS\Module\UserResetToken\DAO\UserResetTokenSaveDAO;
use SetCMS\Module\Template\Servant\TemplateRenderUserResetPasswordServant;
use SetCMS\Module\Template\VO\TemplateRenderedVO;

class UserResetTokenSendTest extends TestCase
{

    use TestTrait;

    public static string $userId = '4c751162-8b67-4f22-b431-ed24c17f0048';
    public static string $userResetToken = '2b9d1c09-b417-43f5-bd7b-5b4db4dd6620';
    public static bool $userResetTokenRefreshExists = false;
    public static string $userResetTokenId = '4662e5e9-7f55-42ad-afe5-0fb50b7c37ce';
    public static ?UserResetTokenEntity $userResetTokenSaved = null;
    public static ?UserResetTokenEntity $userResetTokenRetrived = null;

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

        $sendToUser = UserResetTokenSendToUserServant::new($this->container($this->mocks()));
        $sendToUser->user = self::newUser();
        $sendToUser->serve();

        $this->assertEquals(UserResetTokenSendTest::$userResetTokenRetrived, UserResetTokenSendTest::$userResetTokenSaved);
        $this->assertEquals(UserResetTokenSendTest::$userResetTokenSaved->dateExpired->format('Y-m-d H:i:s'), (new \DateTime('+120 seconds'))->format('Y-m-d H:i:s'));

        UserResetTokenSendTest::$userResetTokenRefreshExists = false;
        UserResetTokenSendTest::$userResetTokenRetrived = null;
        UserResetTokenSendTest::$userResetTokenSaved = null;

        $sendToUser2 = UserResetTokenSendToUserServant::new($this->container($this->mocks()));
        $sendToUser2->user = self::newUser();
        $sendToUser2->serve();

        $this->assertNotEquals(UserResetTokenSendTest::$userResetTokenRetrived, UserResetTokenSendTest::$userResetTokenSaved);
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
                'USER_RESET_TOKEN_REFRESH_EXISTS' => UserResetTokenSendTest::$userResetTokenRefreshExists,
                'USER_RESET_TOKEN_EXPIRED_SECONDS' => 120,
            ],
            TemplateRenderUserResetPasswordServant::class => new class($container) extends TemplateRenderUserResetPasswordServant {

                #[\Override]
                public function serve(): void
                {
                    $this->templateRendered = new TemplateRenderedVO();
                    $this->templateRendered->title = $this->user->id->uuid;
                    $this->templateRendered->content = $this->userResetToken->userId->uuid;
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
