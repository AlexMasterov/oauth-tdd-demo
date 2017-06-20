<?php
declare(strict_types=1);

namespace Tests\Controller\Logout;

use Oauth\Controller\Logout\{
    LogoutController,
    LogoutView
};
use Oauth\Tests\Controller\{
    Collaborator\CanNewCollaborator,
    HttpStatus
};
use Oauth\Tests\Infrastructure\{
    InMemoryStorage,
    StubCommandBus
};
use PHPUnit\Framework\TestCase;

class LogoutControllerTest extends TestCase
{
    use CanNewCollaborator;
    use InMemoryStorage;
    use StubCommandBus;

    public function testLogout(): void
    {
        // Stub
        $redirectUrl = '/';

        // Execute
        $response = $this->controller()
            ->post($this->newRequest());

        // Verify
        self::assertInstanceOf($this->response(), $response);
        self::assertSame(HttpStatus::HTTP_FOUND, $response->getStatusCode());

        $redirectToUrl = $response->headers->get('Location');

        self::assertSame($redirectUrl, $redirectToUrl);
    }

    private function controller(): LogoutController
    {
        return new LogoutController(
            new LogoutView($this->newEngine()),
            $this->newStorage()
        );
    }
}
