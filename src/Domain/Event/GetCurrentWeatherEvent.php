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
     * @var array
     */
    private $dataResponse;

    /**
     * GetCurrentWeatherEvent constructor.
     * @param array $dataResponse
     */
    public function __construct(array $dataResponse)
    {
        $this->dataResponse = $dataResponse;
    }

    /**
     * @return array
     */
    public function getDataResponse(): array
    {
        return $this->dataResponse;
    }
}
