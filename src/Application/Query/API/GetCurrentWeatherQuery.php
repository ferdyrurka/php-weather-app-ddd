<?php
declare(strict_types=1);

namespace App\Application\Query\API;

use Ferdyrurka\CommandBus\Query\QueryInterface;

/**
 * Class GetCurrentWeatherCommand
 * @package App\Domain\Command
 * @codeCoverageIgnore
 */
class GetCurrentWeatherQuery implements QueryInterface
{
    /**
     * @var string
     */
    private string $cityName;

    /**
     * GetCurrentWeatherCommand constructor.
     * @param string $cityName
     */
    public function __construct(string $cityName)
    {
        $this->cityName = $cityName;
    }

    /**
     * @return string
     */
    public function getCityName(): string
    {
        return $this->cityName;
    }
}
