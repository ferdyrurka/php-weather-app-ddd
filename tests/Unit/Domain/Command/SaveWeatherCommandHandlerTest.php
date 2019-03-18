<?php
declare(strict_types=1);

namespace App\Tests\Unit\Domain\Command;

use App\Application\Factory\CreateWeatherFactory;
use App\Domain\Command\SaveWeatherCommand;
use App\Domain\Command\SaveWeatherCommandHandler;
use App\Domain\Entity\Weather;
use App\Domain\Repository\WeatherRepositoryInterface;
use \Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

/**
 * Class SaveWeatherCommandHandlerTest
 * @package App\Tests\Unit\Domain\Command
 */
class SaveWeatherCommandHandlerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var WeatherRepositoryInterface
     */
    private $weatherRepository;

    /**
     * @var SaveWeatherCommandHandler
     */
    private $saveWeatherCommandHandler;

    /**
     * @var Weather
     */
    private $weather;

    /**
     * @var SaveWeatherCommand
     */
    private $saveWeatherCommand;

    /**
     *
     */
    public function setUp(): void
    {
        $this->weatherRepository = Mockery::mock(WeatherRepositoryInterface::class);
        $this->weatherRepository->shouldReceive('save')->withArgs([Weather::class])->once();


        $this->weather = Mockery::mock(Weather::class);

        $this->saveWeatherCommand = Mockery::mock(SaveWeatherCommand::class);
        $this->saveWeatherCommand->shouldReceive('getResponseData')->andReturn(['data' => 'responseValue']);

        $this->saveWeatherCommandHandler = new SaveWeatherCommandHandler($this->weatherRepository);
    }

    /**
     * @test
     */
    public function handleUpdate(): void
    {
        $this->weatherRepository->shouldReceive('findOneByCityName')->once()->withArgs(['cityNameValue'])
            ->andReturn($this->weather)
        ;
        $this->saveWeatherCommand->shouldReceive('getCityName')->once()->andReturn('cityNameValue');

        $this->weather->shouldReceive('setData')->once()
            ->withArgs(
                function (array $data) :bool {
                    if (!isset($data['data']) || $data['data'] !== 'responseValue') {
                        return false;
                    }

                    return true;
                }
            )
        ;

        $this->saveWeatherCommandHandler->handle($this->saveWeatherCommand);
    }

    /**
     * @runInSeparateProcess
     * @test
     */
    public function handleCreateNewWeather(): void
    {
        $this->weatherRepository->shouldReceive('findOneByCityName')->once()->withArgs(['cityNameValue'])
            ->andReturnNull()
        ;
        $this->saveWeatherCommand->shouldReceive('getCityName')->twice()->andReturn('cityNameValue');

        $createWeatherFactory = Mockery::mock('overload:' . CreateWeatherFactory::class);
        $createWeatherFactory->shouldReceive('__construct')->once()
            ->withArgs(
                function (array $data) :bool {
                    if (!isset($data['data']) || $data['data'] !== 'responseValue') {
                        return false;
                    }

                    return true;
                }
            )
        ;
        $createWeatherFactory->shouldReceive('getWeather')->once()->andReturn($this->weather);

        $this->saveWeatherCommandHandler->handle($this->saveWeatherCommand);
    }
}
