<?php
declare(strict_types=1);

namespace App\Infrastructure\OWM;

use App\Domain\Exception\ServerOWMException;
use App\Domain\Exception\WeatherNotFoundException;
use App\Domain\OWM\WeatherOWMRepositoryInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;

/**
 * Class WeatherOWMRepository
 * @package App\Infrastructure\OWM
 */
class WeatherOWMRepository implements WeatherOWMRepositoryInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $OWMApiKey;

    /**
     * WeatherOWMRepository constructor.
     * @param Client $client
     * @param string $OWMApiKey
     */
    public function __construct(Client $client, string $OWMApiKey)
    {
        $this->client = $client;
        $this->OWMApiKey = $OWMApiKey;
    }

    /**
     * @param string $cityName
     * @return array
     */
    public function getOneByCityName(string $cityName): array
    {
        try {
            $response = $this->client->get(
                'https://api.openweathermap.org/data/2.5/weather?q=' .
                $cityName . '&APPID=' . $this->OWMApiKey
            );
        } catch (ClientException $clientException) {
            throw new WeatherNotFoundException(
                'Current weather not found by city name: ' . $cityName
            );
        } catch (ServerException | RequestException $exception) {
            throw  new ServerOWMException('Server exception by OWM');
        }

        return \json_decode((string) $response->getBody(), true);
    }
}
