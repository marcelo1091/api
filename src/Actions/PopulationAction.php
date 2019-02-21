<?php

namespace App\Actions;

use App\Transformers\PopulationTransformer;
use GuzzleHttp\Client;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class PopulationAction
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $http;

    /**
     * @var \League\Fractal\Manager
     */
    protected $fractal;

    /**
     * @param \Slim\Container $container
     */
    public function __construct(Container $container)
    {
        $this->http    = $container->get(Client::class);
        $this->fractal = $container->get(Manager::class);
    }

    /**
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(Request $request, Response $response, array $args): ResponseInterface
    {
        $year    = $args['year'];
        $country = $args['country'];
        $age     = $args['age'];
        $gender  = $args['gender'];

        $httpResponse = $this->http->get("population/{$year}/{$country}/{$age}");
        $population   = json_decode((string) $httpResponse->getBody(), true);

        $resource = new Collection($population, new PopulationTransformer($gender));

        $population = $this->fractal->createData($resource);

        return $response->withJson($population->toArray());
    }
}
