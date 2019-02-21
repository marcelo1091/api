<?php

namespace App\Services\Providers;

use GuzzleHttp\Client;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class HttpServiceProvider implements ServiceProviderInterface
{
    /**
     * @param \Pimple\Container $container
     * @return void
     */
    public function register(Container $container): void
    {
        $client = new Client([
            'base_uri' => getenv('API_BASE_URL'),
            'timeout'  => 2,
        ]);

        $container[Client::class] = function () use ($client) {
            return $client;
        };
    }
}
