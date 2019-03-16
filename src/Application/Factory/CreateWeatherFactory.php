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
     * CreateWeatherFactory constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return Weather
     */
    public function getWeather(): Weather
    {
        $weather = new Weather();
        $weather->setCityName(strtolower($this->data['name']));
        $weather->setData($this->data);

        return $weather;
    }
}
