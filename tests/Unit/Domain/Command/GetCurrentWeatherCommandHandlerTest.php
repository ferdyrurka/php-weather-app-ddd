<?php
declare(strict_types=1);

namespace App\Tests\Unit\Domain\Command;

use App\Domain\Command\GetCurrentWeatherCommand;
use App\Domain\Command\GetCurrentWeatherCommandHandler;
use App\Domain\Event\GetCurrentWeatherEvent;
use App\Domain\Exception\ServerOWMException;
use App\Domain\Exception\WeatherNotFoundException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class GetCurrentWeatherCommandHandlerTest
 * @package App\Tests\Unit\Domain\Command
 */
class GetCurrentWeatherCommandHandlerTest extends TestCase
{
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var GetCurrentWeatherCommandHandler
     */
    private $getCurrentWeatherCommandHandler;

    /**
     * @var GetCurrentWeatherCommand
     */
    private $getCurrentWeatherCommand;

    /**
     *
     */
    protected function setUp(): void
    {
        $this->getCurrentWeatherCommand = Mockery::mock(GetCurrentWeatherCommand::class);
        $this->getCurrentWeatherCommand->shouldReceive('getCityName')->once()->andReturn('Warsaw');

        $this->client = Mockery::mock(Client::class);
        $this->eventDispatcher = Mockery::mock(EventDispatcherInterface::class);
        $this->getCurrentWeatherCommandHandler = new GetCurrentWeatherCommandHandler(
            $this->client,
            $this->eventDispatcher,
            'OWN_API_KEY_VALUE'
        );
    }


    /**
     * @test
     */
    public function handleOk(): void
    {
        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getBody')->once()->andReturn(
            \json_encode(['cod' => 200, 'other' => 'value'])
        );

        $this->client->shouldReceive('get')->once()->andReturn($response)
            ->withArgs(
                function (string $uri): bool {
                    return $this->validateUriClient($uri);
                }
            )
        ;

        $this->eventDispatcher->shouldReceive('dispatch')->once()
            ->withArgs([GetCurrentWeatherEvent::NAME, GetCurrentWeatherEvent::class])
        ;

        $this->getCurrentWeatherCommandHandler->handle($this->getCurrentWeatherCommand);
    }

    /**
     * @test
     */
    public function handleServerException(): void
    {
        $this->client->shouldReceive('get')->once()->andThrow(Mockery::mock(ServerException::class))
            ->withArgs(
                function (string $uri): bool {
                    return $this->validateUriClient($uri);
                }
            )
        ;

        $this->expectException(ServerOWMException::class);
        $this->getCurrentWeatherCommandHandler->handle($this->getCurrentWeatherCommand);
    }

    /**
     * @test
     */
    public function handleRequestException(): void
    {
        $this->client->shouldReceive('get')->once()->andThrow(Mockery::mock(RequestException::class))
            ->withArgs(
                function (string $uri): bool {
                    return $this->validateUriClient($uri);
                }
            )
        ;

        $this->expectException(ServerOWMException::class);
        $this->getCurrentWeatherCommandHandler->handle($this->getCurrentWeatherCommand);
    }

    /**
     * @test
     */
    public function handleClientException(): void
    {
        $this->client->shouldReceive('get')->once()->andThrow(Mockery::mock(ClientException::class))
            ->withArgs(
                function (string $uri): bool {
                    return $this->validateUriClient($uri);
                }
            )
        ;

        $this->expectException(WeatherNotFoundException::class);
        $this->getCurrentWeatherCommandHandler->handle($this->getCurrentWeatherCommand);
    }

    /**
     * @test
     */
    public function handleCod404(): void
    {
        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getBody')->once()->andReturn(
            \json_encode(['cod' => 404, 'other' => 'value'])
        );

        $this->client->shouldReceive('get')->once()->andReturn($response)
            ->withArgs(
                function (string $uri): bool {
                    return $this->validateUriClient($uri);
                }
            )
        ;

        $this->expectException(WeatherNotFoundException::class);
        $this->getCurrentWeatherCommandHandler->handle($this->getCurrentWeatherCommand);
    }

    /**
     * @test
     */
    public function handleCodUnknown(): void
    {
        $response = Mockery::mock(ResponseInterface::class);
        $response->shouldReceive('getBody')->once()->andReturn(
            \json_encode(['cod' => 401, 'other' => 'value'])
        );

        $this->client->shouldReceive('get')->once()->andReturn($response)
            ->withArgs(
                function (string $uri): bool {
                    return $this->validateUriClient($uri);
                }
            )
        ;

        $this->expectException(ServerOWMException::class);
        $this->getCurrentWeatherCommandHandler->handle($this->getCurrentWeatherCommand);
    }

    /**
     * @param string $uri
     * @return bool
     */
    private function validateUriClient(string $uri): bool
    {
        if ($uri !== 'https://api.openweathermap.org/data/2.5/weather?q=Warsaw&APPID=OWN_API_KEY_VALUE') {
            return false;
        }

        return true;
    }
}
