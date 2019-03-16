<?php
declare(strict_types=1);

namespace App\Domain\Command;

use App\Domain\Event\GetCurrentWeatherEvent;
use App\Domain\Exception\ServerOWMException;
use App\Domain\Exception\WeatherNotFoundException;
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
     * @var Client
     */
    private $client;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var string
     */
    private $OWMApiKey;

    /**
     * GetCurrentWeatherCommandHandler constructor.
     * @param Client $client
     * @param EventDispatcherInterface $eventDispatcher
     * @param string $OWMApiKey
     */
    public function __construct(Client $client, EventDispatcherInterface $eventDispatcher, string $OWMApiKey)
    {
        $this->client = $client;
        $this->eventDispatcher = $eventDispatcher;
        $this->OWMApiKey = $OWMApiKey;
    }

    /**
     * @param CommandInterface $command
     */
    public function handle(CommandInterface $command): void
    {
        $getCurrentWeatherEvent = new GetCurrentWeatherEvent($this->getCurrentWeather($command->getCityName()));

        $this->eventDispatcher->dispatch(GetCurrentWeatherEvent::NAME, $getCurrentWeatherEvent);
    }

    /**
     * @param string $cityName
     * @return array
     */
    private function getCurrentWeather(string $cityName): array
    {
        try {
            $response = $this->client->get(
                'https://samples.openweathermap.org/data/2.5/weather?q=' .
                $cityName . '&APPID=' . $this->OWMApiKey
            );
        } catch (ClientException $clientException) {
            throw new WeatherNotFoundException(
                'Current weather not found by city name: ' . $cityName
            );
        } catch (ServerException | RequestException $exception) {
            throw  new ServerOWMException('Server exception by OWM');
        }

        $bodyArray = \json_decode((string) $response->getBody(), true);

        switch ((int) $bodyArray['cod']) {
            case 200:
                break;
            case 404:
                throw new WeatherNotFoundException(
                    'Current weather not found by city name: ' . $cityName
                );
            default:
                throw  new ServerOWMException('Server exception by OWM');
        }

        return $bodyArray;
    }
}
