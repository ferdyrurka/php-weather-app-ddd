<?php
declare(strict_types=1);

namespace App\Domain\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class GetCurrentWeatherEvent
 * @package App\Domain\Event
 */
class GetCurrentWeatherEvent extends Event
{
    public const NAME = 'get.current.weather';

    /**
     * @var string
     */
    private $jsonData;

    /**
     * GetCurrentWeatherEvent constructor.
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
