<?php

namespace App\Services;

class CountryManager
{
    /**
     * @var string
     */
    protected $from;

    /**
     * @var string
     */
    protected $to;

    /**
     * @param string $from
     * @return self
     */
    public function from(string $from = null): self
    {
        $this->from = strtolower($from);

        return $this;
    }

    /**
     * @param string $to
     * @return void
     */
    public function to(string $to = null): self
    {
        $this->to = strtolower($to);

        return $this;
    }

    /**
     * @param array $countries
     * @return array
     */
    public function getCountries(array $countries): array
    {
        $this->reverseCharacters();

        return array_filter($countries, function ($country) {
            $letter = strtolower(substr($country['name'], 0, 1));

            if ($letter >= $this->from && $letter <= $this->to) {
                return $country;
            }
        });
    }

    /**
     * @return void
     */
    protected function reverseCharacters(): void
    {
        if ($this->from > $this->to) {
            $temp = $this->to;

            $this->to   = $this->from;
            $this->from = $temp;
        }
    }
}
