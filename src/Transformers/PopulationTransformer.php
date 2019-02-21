<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class PopulationTransformer extends TransformerAbstract
{
    public function __construct(string $gender)
    {
        $this->gender = $gender;
    }

    /**
     * @param array $population
     * @return array
     */
    public function transform(array $population): array
    {
        return [
            'country' => $population['country'],
            'amount'  => $population[$this->gender],
            'age'     => $population['age'],
            'year'    => $population['year'],
            'gender'  => $this->gender,
        ];
    }
}
