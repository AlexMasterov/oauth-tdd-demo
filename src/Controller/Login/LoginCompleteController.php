<?php
declare(strict_types=1);

namespace Oauth\Controller\Login;

use League\OAuth2\Client\Token\AccessToken;
use Oauth\Controller\Login\LoginView;
use Oauth\Domain\Authorization\FetchTokenCommand;
use Oauth\Infrastructure\{
    CommandBus\CommandBusInterface,
    Storage\StorageInterface
};
use Symfony\Component\HttpFoundation\{
    Request,
    Response
};

final class LoginCompleteController
{
    public function __construct(
        LoginView $view,
        CommandBusInterface $bus,
        StorageInterface $storage
    ) {
        $this->view = $view;
        $this->bus = $bus;
        $this->storage = $storage;
    }

    public function get(Request $request): Response
    {
        $code = $request->query->get('code');
        $state = $this->authState();

        if (empty($code) || empty($state)) {
            return $this->view->redirect('/login');
        }

        $command = FetchTokenCommand::forCode($code, $state);
        $token = $this->bus->handle($command);

        return $this->finish($token);
    }

    /**
     * @var LoginView
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

    private function finish(AccessToken $token): Response
    {
        $this->storage->set('github-token', json_encode($token));

        return $this->view->redirect('/');
    }

    private function authState(): ?string
    {
        return $this->storage->get('oauth-state');
    }
}
