<?php
declare(strict_types=1);

namespace App\Domain\Command;

use Ferdyrurka\CommandBus\Command\CommandInterface;

/**
 * Class GetCurrentWeatherCommand
 * @package App\Domain\Command
 */
class GetCurrentWeatherCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $cityName;

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
