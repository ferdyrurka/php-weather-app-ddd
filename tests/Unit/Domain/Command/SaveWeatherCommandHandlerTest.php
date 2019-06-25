<?php
declare(strict_types=1);

namespace App\Tests\Unit\Domain\Command;

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
    private WeatherRepositoryInterface $weatherRepository;

    /**
     * @var SaveWeatherCommandHandler
     */
    private SaveWeatherCommandHandler $saveWeatherCommandHandler;

    /**
     * @var SaveWeatherCommand
     */
    private SaveWeatherCommand $saveWeatherCommand;

    /**
     *
     */
    public function setUp(): void
    {
        $this->weatherRepository = Mockery::mock(WeatherRepositoryInterface::class);
        $this->saveWeatherCommand = Mockery::mock(SaveWeatherCommand::class);
        $this->saveWeatherCommand->shouldReceive('getResponseData')->andReturn(['data' => 'responseValue']);
        $this->saveWeatherCommand->shouldReceive('getCityName')->andReturn('cityNameValue');

        $this->saveWeatherCommandHandler = new SaveWeatherCommandHandler($this->weatherRepository);
    }

    /**
     * @test
     */
    public function handleUpdate(): void
    {
        $this->weatherRepository->shouldReceive('findOneByCityName')->once()->withArgs(['cityNameValue'])
            ->andReturn(new Weather())
        ;
        $this->weatherRepository->shouldReceive('save')->withArgs([Weather::class])->once();
        $this->saveWeatherCommandHandler->handle($this->saveWeatherCommand);
    }
}
