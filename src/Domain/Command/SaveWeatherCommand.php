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
    private $jsonData;

    /**
     * SaveWeatherCommand constructor.
     * @param string $jsonData
     */
    public function __construct(string $jsonData)
    {
        $this->jsonData = $jsonData;
    }

    /**
     * @return string
     */
    public function getJsonData(): string
    {
        return $this->jsonData;
    }
}
