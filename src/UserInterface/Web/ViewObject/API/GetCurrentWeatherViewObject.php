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
     * @var array
     */
    private array $data;

    /**
     * GetCurrentWeatherViewObject constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}