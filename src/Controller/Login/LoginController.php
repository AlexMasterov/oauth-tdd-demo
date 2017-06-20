<?php
declare(strict_types=1);

namespace Oauth\Controller\Login;

use Oauth\Controller\Login\LoginView;
use Symfony\Component\HttpFoundation\{
    Request,
    Response
};

final class LoginController
{
    public function __construct(LoginView $view)
    {
        $this->view = $view;
    }

    public function get(Request $request): Response
    {
        return $this->view->showLogin();
    }

    /**
     * @var LoginView
     */
    private $view;
}
