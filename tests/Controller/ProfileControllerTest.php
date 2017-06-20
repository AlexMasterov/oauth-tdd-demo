<?php
declare(strict_types=1);

namespace Tests\Controller;

use Oauth\Controller\{
    ProfileController,
    ProfileView
};
use Oauth\Domain\API\{
    FetchFollowersCommand,
    FetchRepositoriesCommand,
    FetchStarsCommand
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

class ProfileControllerTest extends TestCase
{
    use CanNewCollaborator;
    use InMemoryStorage;
    use StubCommandBus;

    public function testProfile(): void
    {
        // Stub
        $commands = [
            FetchFollowersCommand::class => [],
            FetchRepositoriesCommand::class => [],
            FetchStarsCommand::class => [],
        ];

        // Execute
        $response = $this->controller($commands)
            ->get($this->newRequest());

        // Verify
        self::assertInstanceOf($this->response(), $response);
        self::assertSame(HttpStatus::HTTP_FOUND, $response->getStatusCode());
    }

    private function controller(array $commands = []): ProfileController
    {
        return new ProfileController(
            new ProfileView($this->newEngine()),
            $this->newCommandBus($commands),
            $this->newStorage()
        );
    }
}
