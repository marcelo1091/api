<?php

$app->get('/population[/{country}[/{year}[/{age}[/{gender}]]]]', \App\Actions\PopulationAction::class);
$app->get('/countries/{from}/{to}', \App\Actions\CountryAction::class);
