<?php
declare(strict_types=1);

namespace App\Domain\Command;

use App\Domain\Event\GetCurrentWeatherEvent;
use App\Domain\Exception\ServerOWMException;
use App\Domain\Exception\WeatherNotFoundException;
use App\Infrastructure\OWM\WeatherOWMRepository;
use Ferdyrurka\CommandBus\Command\CommandInterface;
use Ferdyrurka\CommandBus\Handler\HandlerInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class GetCurrentWeatherCommandHandler
 * @package App\Domain\Command
 */
class GetCurrentWeatherCommandHandler implements HandlerInterface
{
    /**
     * @var WeatherOWMRepository
     */
    private $weatherOWMRepository;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * GetCurrentWeatherCommandHandler constructor.
     * @param WeatherOWMRepository $WeatherOWMRepository
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(WeatherOWMRepository $WeatherOWMRepository, EventDispatcherInterface $eventDispatcher)
    {
        $this->weatherOWMRepository = $WeatherOWMRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param CommandInterface $command
     */
    public function handle(CommandInterface $command): void
    {
        $getCurrentWeatherEvent = new GetCurrentWeatherEvent(
            $this->weatherOWMRepository->getOneByCityName($command->getCityName())
        );

        $this->eventDispatcher->dispatch(GetCurrentWeatherEvent::NAME, $getCurrentWeatherEvent);
    }
}
