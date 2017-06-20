<?php
declare(strict_types=1);

namespace Tests\Controller\Login;

use Oauth\Controller\Login\{
    LoginController,
    LoginView
};
use Oauth\Tests\Controller\{
    Collaborator\CanNewCollaborator,
    HttpStatus
};
use PHPUnit\Framework\TestCase;

class LoginControllerTest extends TestCase
{
    use CanNewCollaborator;

    public function testLogin(): void
    {
        // Execute
        $response = $this->controller()
            ->get($this->newRequest());

        // Verify
        self::assertInstanceOf($this->response(), $response);
        self::assertSame(HttpStatus::HTTP_OK, $response->getStatusCode());
    }

    private function controller(): LoginController
    {
        return new LoginController(
            new LoginView($this->newEngine())
        );
    }
}
