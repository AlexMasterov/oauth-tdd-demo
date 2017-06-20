<?php
declare(strict_types=1);

namespace Oauth\Domain\API;

use League\OAuth2\Client\Provider\Github;

class FetchStarsHandler
{
    public function __construct(Github $github)
    {
        $this->github = $github;
    }

    public function handle(FetchStarsCommand $command): array
    {
        $request = $this->github->getAuthenticatedRequest(
            $this->method(),
            $this->url(),
            $command->token()
        );

        return $this->github->getParsedResponse($request);
    }

    /**
     * @var Github
     */
    private $github;

    private function method(): string
    {
        return 'GET';
    }

    private function url(): string
    {
        // https://developer.github.com/v3/users/:username/starred
        return $this->github->apiDomain . '/user/starred';
    }
}
