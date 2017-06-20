<?php
declare(strict_types=1);

namespace Oauth\Tests\Controller\Collaborator;

use Symfony\Component\Routing\{
    Generator\UrlGeneratorInterface,
    RequestContext
};

trait UrlGenerator
{
    protected function newUrlGenerator(): UrlGeneratorInterface
    {
        return new class() implements UrlGeneratorInterface {
            public function generate(
                $name,
                $parameters = [],
                $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH
            ) {
                return $name;
            }

            public function setContext(RequestContext $context)
            {
            }

            public function getContext()
            {
            }
        };
    }
}
