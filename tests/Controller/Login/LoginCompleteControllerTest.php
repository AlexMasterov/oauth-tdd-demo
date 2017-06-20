<?php
declare(strict_types=1);

namespace Tests\Controller\Login;

use League\OAuth2\Client\Token\AccessToken;
use Oauth\Controller\Login\{
    LoginCompleteController,
    LoginView
};
use Oauth\Domain\Authorization\FetchTokenCommand;
use Oauth\Tests\Controller\{
    Collaborator\CanNewCollaborator,
    HttpStatus
};
use Oauth\Tests\Domain\CanAccessTokenStub;
use Oauth\Tests\Infrastructure\{
    InMemoryStorage,
    StubCommandBus
};
use PHPUnit\Framework\TestCase;

class LoginCompleteControllerTest extends TestCase
{
    use CanAccessTokenStub;
    use CanNewCollaborator;
    use InMemoryStorage;
    use StubCommandBus;

    public function testLoginCompleteSuccess(): void
    {
        // Stub
        $url = '/';
        $query = ['code' => '123'];
        $store = ['oauth-state' => 'state'];
        $commands = [
            FetchTokenCommand::class => $this->accessToken(),
        ];

        // Execute
        $response = $this->controller($commands, $store)
            ->get($this->newRequest($query));

        // Verify
        self::assertInstanceOf($this->response(), $response);
        self::assertSame(HttpStatus::HTTP_FOUND, $response->getStatusCode());

        $redirectToUrl = $response->headers->get('Location');

        self::assertSame($url, $redirectToUrl);
    }

    public function testLoginCompleteFailure(): void
    {
        // Stub
        $url = '/login';
        $query = [];
        $commands = [
            FetchTokenCommand::class => $this->accessToken(),
        ];

        // Execute
        $response = $this->controller($commands)
            ->get($this->newRequest($query));

        // Verify
        self::assertInstanceOf($this->response(), $response);
        self::assertSame(HttpStatus::HTTP_FOUND, $response->getStatusCode());

        $redirectToUrl = $response->headers->get('Location');

        self::assertSame($url, $redirectToUrl);
    }

    private function controller(
        array $commands = [],
        array $store = []
    ): LoginCompleteController {
        return new LoginCompleteController(
            new LoginView($this->newEngine()),
            $this->newCommandBus($commands),
            $this->newStorage($store)
        );
    }
}
