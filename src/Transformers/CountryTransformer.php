<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class CountryTransformer extends TransformerAbstract
{
    /**
     * @param string $country
     * @return array
     */
    public function transform(string $country): array
    {
        return ['name' => $country];
    }
}
