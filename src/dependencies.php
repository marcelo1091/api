<?php

use Slim\App;

$dotenv = \Dotenv\Dotenv::create(dirname(__DIR__));
$dotenv->load();

$container = $app->getContainer();

$container->register(new \App\Services\Providers\HttpServiceProvider());

$container[\League\Fractal\Manager::class] = function () {
    return new \League\Fractal\Manager();
};

$container[\App\Services\CountryManager::class] = function () {
    return new \App\Services\CountryManager();
};

$container[\App\Transformers\PopulationTransformer::class] = function () {
    return new \App\Transformers\PopulationTransformer();
};

$container[\App\Transformers\CountryTransformer::class] = function () {
    return new \App\Transformers\CountryTransformer();
};
