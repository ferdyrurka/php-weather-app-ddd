<?php
declare(strict_types=1);

namespace App\Domain\Command;

use Ferdyrurka\CommandBus\Command\CommandInterface;

/**
 * Class SaveWeatherCommand
 * @package App\Domain\Command
 */
class SaveWeatherCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $cityName;

    /**
     * @var string
     */
    private $jsonData;

    /**
     * SaveWeatherCommand constructor.
     * @param string $cityName
     * @param string $jsonData
     */
    public function __construct(string $cityName, string $jsonData)
    {
        $this->cityName = $cityName;
        $this->jsonData = $jsonData;
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
    public function getJsonData(): string
    {
        return $this->jsonData;
    }
}
