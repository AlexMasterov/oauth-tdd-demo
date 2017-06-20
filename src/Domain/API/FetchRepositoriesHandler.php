<?php
declare(strict_types=1);

namespace Oauth\Domain\API;

use League\OAuth2\Client\{
    Provider\Github,
    Tool\QueryBuilderTrait
};

class FetchRepositoriesHandler
{
    use QueryBuilderTrait;

    public function __construct(Github $github)
    {
        $this->github = $github;
    }

    public function handle(FetchRepositoriesCommand $command): array
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
        // https://developer.github.com/v3/repos/#list-your-repositories
        static $params = [
            'visibility' => 'public',
            'affiliation' => 'owner',
        ];

        return $this->github->apiDomain . '/user/repos?' . $this->buildQueryString($params);
    }
}
