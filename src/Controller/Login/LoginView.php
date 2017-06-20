<?php
declare(strict_types=1);

namespace Oauth\Controller\Login;

use Oauth\Response\CanRedirect;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;

final class LoginView
{
    use CanRedirect;

    public function __construct(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    public function showLogin(): Response
    {
        $content = $this->engine->render('@App/login.html.twig');

        return new Response($content);
    }

    /**
     * @var EngineInterface
     */
    private $engine;
}
