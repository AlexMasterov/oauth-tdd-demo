<?php
declare(strict_types=1);

namespace Oauth\Controller;

use Oauth\Controller\ProfileView;
use Oauth\Domain\API\{
    FetchFollowersCommand,
    FetchRepositoriesCommand,
    FetchStarsCommand
};
use Oauth\Infrastructure\{
    CommandBus\CommandBusInterface,
    Storage\StorageInterface
};
use Symfony\Component\HttpFoundation\{
    Request,
    Response
};

final class ProfileController
{
    public function __construct(
        ProfileView $view,
        CommandBusInterface $bus,
        StorageInterface $storage
    ) {
        $this->view = $view;
        $this->bus = $bus;
        $this->storage = $storage;
    }

    public function get(Request $request): Response
    {
        if (false === $this->storage->has('github-token')) {
            return $this->view->redirect('/login');
        }

        $token = $this->token();

        $repositories = FetchRepositoriesCommand::forToken($token);
        $followers = FetchFollowersCommand::forToken($token);
        $stars = FetchStarsCommand::forToken($token);

        return $this->view->render(
            $this->bus->handle($repositories),
            $this->bus->handle($followers),
            $this->bus->handle($stars)
        );
    }

    /**
     * @var ProfileView
     */
    private $view;

    /**
     * @var CommandBusInterface
     */
    private $bus;

    /**
     * @var StorageInterface
     */
    private $storage;

    private function token(): string
    {
        $token = $this->storage->get('github-token');
        $token = json_decode($token, true);

        return $token['access_token'];
    }
}
