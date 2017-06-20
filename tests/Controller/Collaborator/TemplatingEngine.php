<?php
declare(strict_types=1);

namespace Oauth\Tests\Controller\Collaborator;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;

trait TemplatingEngine
{
    protected function newEngine(): EngineInterface
    {
        return new class() implements EngineInterface {
            public function renderResponse(
                $view,
                array $parameters = [],
                Response $response = null
            ) {
                return new Response($parameters);
            }

            public function render($name, array $parameters = [])
            {
            }

            public function exists($name)
            {
            }

            public function supports($name)
            {
            }
        };
    }
}
