<?php

declare(strict_types=1);

namespace SetCMS\Test;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use SetCMS\UUID;
use SetCMS\Module\User\DAO\UserRetrieveManyByCriteriaDAO;
use SetCMS\Module\User\Entity\UserEntity;
use SetCMS\Module\UserResetToken\Servant\UserResetTokenLinkServant;
use SetCMS\Module\UserResetToken\Entity\UserResetTokenEntity;
use SetCMS\Module\UserResetToken\DAO\UserResetTokenRetrieveManyByCriteriaDAO;
use SetCMS\Module\UserResetToken\DAO\UserResetTokenSaveDAO;
use SetCMS\Module\Template\Servant\TemplateRenderUserResetPasswordServant;
use SetCMS\Module\Template\VO\TemplateRenderedVO;

class UserResetTokenLinkTest extends TestCase
{

    use TestTrait;

    public static string $userId = '4c751162-8b67-4f22-b431-ed24c17f0048';
    public static string $userResetToken = '2b9d1c09-b417-43f5-bd7b-5b4db4dd6620';
    public static bool $userResetTokenRefreshExists = false;
    public static string $userResetTokenId = '4662e5e9-7f55-42ad-afe5-0fb50b7c37ce';
    public static ?UserResetTokenEntity $userResetTokenSaved;
    public static int $userResetTokenDateExpiredSeconds = 100;

    public function testNotExistUser(): void
    {
        $tokenLink = UserResetTokenLinkServant::new($this->container($this->mocks()));
        $tokenLink->email = 'admin1@admin';
        $tokenLink->serve();

        $this->assertEmpty($tokenLink->userResetToken);
    }

    public function testExistUserRefreshCases(): void
    {
        UserResetTokenLinkTest::$userResetTokenRefreshExists = true;

        $tokenLink = UserResetTokenLinkServant::new($this->container($this->mocks()));
        $tokenLink->email = 'admin@admin';
        $tokenLink->serve();

        $this->assertEquals(UserResetTokenEntity::as($tokenLink->userResetToken)->id->uuid, UserResetTokenLinkTest::$userResetTokenId);
        $this->assertEquals($tokenLink->userResetToken, UserResetTokenLinkTest::$userResetTokenSaved);

        UserResetTokenLinkTest::$userResetTokenRefreshExists = false;

        $tokenLink2 = UserResetTokenLinkServant::new($this->container($this->mocks()));
        $tokenLink2->email = 'admin@admin';
        $tokenLink2->serve();

        $this->assertNotEquals(UserResetTokenEntity::as($tokenLink2->userResetToken)->id->uuid, UserResetTokenLinkTest::$userResetTokenId);
        $this->assertEquals($tokenLink2->userResetToken, UserResetTokenLinkTest::$userResetTokenSaved);
    }

    public function mocks(): \Closure
    {
        return fn(ContainerInterface $container) => [
            'env' => [
                'USER_RESET_TOKEN_REFRESH_EXISTS' => UserResetTokenLinkTest::$userResetTokenRefreshExists,
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
                    UserResetTokenLinkTest::$userResetTokenSaved = $this->userResetToken;
                }
            },
            UserResetTokenRetrieveManyByCriteriaDAO::class => fn($container) => new class($container) extends UserResetTokenRetrieveManyByCriteriaDAO {

                #[\Override]
                public function serve(): void
                {
                    if ($this->userId->uuid === UserResetTokenLinkTest::$userId) {
                        $this->userResetToken = new UserResetTokenEntity();
                        $this->userResetToken->id = new UUID(UserResetTokenLinkTest::$userResetTokenId);
                        $this->userResetToken->token = UserResetTokenLinkTest::$userResetToken;
                        $this->userResetToken->userId = new UUID(UserResetTokenLinkTest::$userId);
                        $this->userResetToken->dateExpired = new \DateTimeImmutable(sprintf('+%s seconds', UserResetTokenLinkTest::$userResetTokenDateExpiredSeconds));
                        $this->userResetTokens = [$this->userResetToken];
                    }
                }
            },
            UserRetrieveManyByCriteriaDAO::class => fn($container) => new class($container) extends UserRetrieveManyByCriteriaDAO {

                #[\Override]
                public function serve(): void
                {
                    if ($this->email === 'admin@admin') {
                        $this->user = new UserEntity();
                        $this->user->id = new UUID(UserResetTokenLinkTest::$userId);
                        $this->user->email = 'admin@admin';

                        $this->users = [$this->user];
                    }
                }
            },
        ];
    }
}
