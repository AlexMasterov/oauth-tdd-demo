<?php
declare(strict_types=1);

namespace Oauth\Controller;

use Oauth\Response\CanRedirect;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;

final class ProfileView
{
    use CanRedirect;

    public function __construct(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    public function render(array $repositories, array $followers, array $stars): Response
    {
        $content = $this->engine->render('@App/profile.html.twig', [
          'repositories' => $repositories ,
          'followers' => $followers,
          'stars' => $stars,
        ]);

        return new Response($content);
    }

    /**
     * @var EngineInterface
     */
    private $engine;
}
