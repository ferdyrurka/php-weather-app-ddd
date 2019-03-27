<?php
declare(strict_types=1);

namespace App\Domain\OWM;

/**
 * Interface WeatherOWMRepositoryInterface
 * @package App\Domain\OWM
 */
interface WeatherOWMRepositoryInterface
{
    /**
     * @param string $cityName
     * @return array
     */
    public function getOneByCityName(string $cityName): array;
}
