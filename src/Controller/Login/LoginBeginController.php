<?php
declare(strict_types=1);

namespace Oauth\Controller\Login;

use Oauth\Controller\Login\LoginView;
use Oauth\Domain\Authorization\{
    LoginCommand,
    LoginState
};
use Oauth\Infrastructure\{
    CommandBus\CommandBusInterface,
    Storage\StorageInterface
};
use Symfony\Component\HttpFoundation\{
    Request,
    Response
};
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class LoginBeginController
{
    public function __construct(
        LoginView $view,
        CommandBusInterface $bus,
        UrlGeneratorInterface $urlGenerator,
        StorageInterface $storage
    ) {
        $this->view = $view;
        $this->bus = $bus;
        $this->urlGenerator = $urlGenerator;
        $this->storage = $storage;
    }

    public function post(Request $request): Response
    {
        $url = $this->loginCompleteUrl();

        $login = LoginCommand::forUser($url);
        $state = $this->bus->handle($login);

        return $this->finish($state);
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
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var StorageInterface
     */
    private $storage;

    private function loginCompleteUrl(): string
    {
        return $this->urlGenerator->generate('app_login_complete', [], UrlGeneratorInterface::ABSOLUTE_URL);
    }

    private function finish(LoginState $login): Response
    {
        $this->storage->set('oauth-state', $login->state());

        return $this->view->redirect($login->url());
    }
}
