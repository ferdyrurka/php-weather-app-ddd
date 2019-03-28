<?php
declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\OWM;

use App\Domain\Exception\ServerOWMException;
use App\Domain\Exception\WeatherNotFoundException;
use App\Infrastructure\OWM\WeatherOWMRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Class WeatherOWMRepositoryTest
 * @package App\Tests\Unit\Infrastructure\OWM
 */
class WeatherOWMRepositoryTest extends TestCase
{
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var WeatherOWMRepository
     */
    private $owmRepository;

    /**
     *
     */
    protected function setUp(): void
    {
        $this->client = Mockery::mock(Client::class);
        $this->owmRepository = new WeatherOWMRepository(
            $this->client,
            'OWN_API_KEY_VALUE'
        );
    }


    /**
     * @test
     */
    public function getOneByCityNameOk(): void
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

        $result = $this->owmRepository->getOneByCityName('Warsaw');

        $this->assertEquals(200, $result['cod']);
        $this->assertEquals('value', $result['other']);
    }

    /**
     * @test
     */
    public function getOneByCityNameServerException(): void
    {
        $this->client->shouldReceive('get')->once()->andThrow(Mockery::mock(ServerException::class))
            ->withArgs(
                function (string $uri): bool {
                    return $this->validateUriClient($uri);
                }
            )
        ;

        $this->expectException(ServerOWMException::class);
        $this->owmRepository->getOneByCityName('Warsaw');
    }

    /**
     * @test
     */
    public function getOneByCityNameRequestException(): void
    {
        $this->client->shouldReceive('get')->once()->andThrow(Mockery::mock(RequestException::class))
            ->withArgs(
                function (string $uri): bool {
                    return $this->validateUriClient($uri);
                }
            )
        ;

        $this->expectException(ServerOWMException::class);
        $this->owmRepository->getOneByCityName('Warsaw');
    }

    /**
     * @test
     */
    public function getOneByCityNameClientException(): void
    {
        $this->client->shouldReceive('get')->once()->andThrow(Mockery::mock(ClientException::class))
            ->withArgs(
                function (string $uri): bool {
                    return $this->validateUriClient($uri);
                }
            )
        ;

        $this->expectException(WeatherNotFoundException::class);
        $this->owmRepository->getOneByCityName('Warsaw');
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
