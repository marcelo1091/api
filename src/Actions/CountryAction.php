<?php

namespace App\Actions;

use App\Services\CountryManager;
use App\Transformers\CountryTransformer;
use GuzzleHttp\Client;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Psr\Http\Message\ResponseInterface;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class CountryAction
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
     * @var \App\Services\CountryManager
     */
    protected $countryManager;

    /**
     * @var \App\Transformers\CountryTransformer
     */
    protected $countryTransformer;

    /**
     * @param \Slim\Container $container
     */

    public function __construct(Container $container)
    {
        $this->http               = $container->get(Client::class);
        $this->fractal            = $container->get(Manager::class);
        $this->countryManager     = $container->get(CountryManager::class);
        $this->countryTransformer = $container->get(CountryTransformer::class);
    }

    /**
     * @param \Slim\Http\Request $request
     * @param \Slim\Http\Response $response
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(Request $request, Response $response, array $args): ResponseInterface
    {
        $httpResponse = $this->http->get('countries');
        $countries    = json_decode((string) $httpResponse->getBody(), true);

        $resource = new Collection($countries['countries'], $this->countryTransformer);

        $countries = $this->fractal->createData($resource);

        $countries = $this->countryManager
            ->from($args['from'])
            ->to($args['to'])
            ->getCountries($countries->toArray()['data']);

        return $response->withJson($countries);
    }
}
