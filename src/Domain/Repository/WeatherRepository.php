<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Weather;

/**
 * Interface WeatherRepository
 * @package App\Domain\Repository
 */
interface WeatherRepository
{
    /**
     * @param string $cityName
     * @return Weather
     */
    public function getOneByCityName(string $cityName): Weather;

    /**
     * @param Weather $weather
     */
    public function save(Weather $weather): void;
}
