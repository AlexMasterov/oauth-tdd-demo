<?php
declare(strict_types=1);

namespace Oauth\Controller\Logout;

use Oauth\Controller\Logout\LogoutView;
use Oauth\Infrastructure\Storage\StorageInterface;
use Symfony\Component\HttpFoundation\{
    Request,
    Response
};

final class LogoutController
{
    public function __construct(
        LogoutView $view,
        StorageInterface $storage
    ) {
        $this->view = $view;
        $this->storage = $storage;
    }

    public function post(Request $request): Response
    {
        $this->storage->clear();

        return $this->view->redirect('/');
    }

    /**
     * @var LogoutView
     */
    private $view;

    /**
     * @var StorageInterface
     */
    private $storage;
}
