<?php
declare(strict_types=1);

namespace App\Domain\Event;

/**
 * Class GetCurrentWeatherEventListener
 * @package App\Domain\Event
 */
class GetCurrentWeatherEventListener
{
    /**
     * @var array
     */
    private $dataResponse;

    /**
     * @param GetCurrentWeatherEvent $event
     */
    public function onGetCurrentWeather(GetCurrentWeatherEvent $event): void
    {
        $this->dataResponse = $event->getDataResponse();
    }

    /**
     * @return array
     */
    public function getDataResponse(): array
    {
        return $this->dataResponse;
    }
}
