<?php
declare(strict_types=1);

namespace Tests\Controller\Login;

use League\OAuth2\Client\Token\AccessToken;
use Oauth\Controller\Login\{
    LoginBeginController,
    LoginView
};
use Oauth\Domain\Authorization\{
    LoginCommand,
    LoginState
};
use Oauth\Tests\Controller\Collaborator\CanNewCollaborator;
use Oauth\Tests\Controller\HttpStatus;
use Oauth\Tests\Infrastructure\{
    InMemoryStorage,
    StubCommandBus
};
use PHPUnit\Framework\TestCase;

class LoginBeginControllerTest extends TestCase
{
    use CanNewCollaborator;
    use InMemoryStorage;
    use StubCommandBus;

    public function testLoginBegin(): void
    {
        // Stub
        $url = '/redirect_uri';
        $state = 'state-auth';
        $commands = [
            LoginCommand::class => new LoginState($url, $state),
        ];

        // Execute
        $response = $this->controller($commands)
            ->post($this->newRequest());

        // Verify
        self::assertInstanceOf($this->response(), $response);
        self::assertSame(HttpStatus::HTTP_FOUND, $response->getStatusCode());

        $redirectToUrl = $response->headers->get('Location');

        self::assertSame($url, $redirectToUrl);
    }

    private function controller(array $commands = []): LoginBeginController
    {
        return new LoginBeginController(
            new LoginView($this->newEngine()),
            $this->newCommandBus($commands),
            $this->newUrlGenerator(),
            $this->newStorage()
        );
    }
}
