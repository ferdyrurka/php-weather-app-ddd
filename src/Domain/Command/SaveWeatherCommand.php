<?php
declare(strict_types=1);

namespace App\Domain\Command;

use Ferdyrurka\CommandBus\Command\CommandInterface;

/**
 * Class SaveWeatherCommand
 * @package App\Domain\Command
 * @codeCoverageIgnore
 */
class SaveWeatherCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $cityName;

    /**
     * @var array
     */
    private $responseData;

    /**
     * SaveWeatherCommand constructor.
     * @param string $cityName
     * @param array $responseData
     */
    public function __construct(string $cityName, array $responseData)
    {
        $this->cityName = $cityName;
        $this->responseData = $responseData;
    }

    /**
     * @return string
     */
    public function getCityName(): string
    {
        return $this->cityName;
    }

    /**
     * @return array
     */
    public function getResponseData(): array
    {
        return $this->responseData;
    }
}
