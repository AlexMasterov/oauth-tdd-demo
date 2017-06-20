<?php
declare(strict_types=1);

namespace Oauth\Tests\Controller\Collaborator;

use Oauth\Tests\Controller\Collaborator\{
    HttpFoundation,
    TemplatingEngine,
    UrlGenerator
};

trait CanNewCollaborator
{
    use HttpFoundation;
    use TemplatingEngine;
    use UrlGenerator;
}
