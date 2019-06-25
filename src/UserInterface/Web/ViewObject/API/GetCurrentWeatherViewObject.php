<?php
declare(strict_types=1);

namespace App\UserInterface\Web\ViewObject\API;

use Ferdyrurka\CommandBus\Query\ViewObject\ViewObjectInterface;

/**
 * Class GetCurrentWeatherViewObject
 * @package App\UserInterface\Web\ViewObject\API
 */
class GetCurrentWeatherViewObject implements ViewObjectInterface
{
    /**
     * @var string
     */
    private $cityName;

    /**
     * @var string
     */
    private $data;

    /**
     * GetCurrentWeatherViewObject constructor.
     * @param string $cityName
     * @param array $data
     */
    public function __construct(string $cityName, array $data)
    {
        $this->cityName = $cityName;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getCityName(): string
    {
        return $this->cityName;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }
}