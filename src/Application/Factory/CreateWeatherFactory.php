<?php
declare(strict_types=1);

namespace App\Application\Factory;

use App\Domain\Entity\Weather;

/**
 * Class CreateWeatherFactory
 * @package App\Application\Factory
 */
class CreateWeatherFactory
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
    private $cityName;

    /**
     * CreateWeatherFactory constructor.
     * @param array $data
     * @param string $cityName
     */
    public function __construct(array $data, string $cityName)
    {
        $this->data = $data;
        $this->cityName = $cityName;
    }


    /**
     * @return Weather
     */
    public function getWeather(): Weather
    {
        $weather = new Weather();
        $weather->setCityName($this->cityName);
        $weather->setData($this->data);

        return $weather;
    }
}
