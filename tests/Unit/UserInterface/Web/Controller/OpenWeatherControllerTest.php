<?php
declare(strict_types=1);

namespace App\Tests\Unit\UserInterface\Web\Controller;

use App\Domain\Command\GetCurrentWeatherCommand;
use App\Domain\Command\SaveWeatherCommand;
use App\Domain\Event\GetCurrentWeatherEventListener;
use App\Domain\Exception\InvalidArgsException;
use App\Domain\Validator\CityNameValidator;
use App\UserInterface\Web\Controller\OpenWeatherController;
use Ferdyrurka\CommandBus\Command\CommandInterface;
use Ferdyrurka\CommandBus\CommandBusInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * Class OpenWeatherControllerTest
 * @package App\Tests\Unit\UserInterface\Web\Controller
 */
class OpenWeatherControllerTest extends TestCase
{
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    /**
     * @var OpenWeatherController
     */
    private $openWeatherController;

    /**
     *
     */
    protected function setUp(): void
    {
        $this->openWeatherController = new OpenWeatherController();
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function getCurrentWeatherInvalidArgs(): void
    {
        $cityNameValidator = Mockery::mock('alias:' . CityNameValidator::class);
        $cityNameValidator->shouldReceive('validate')->once()->withArgs(['cityNameValue'])->andReturnFalse();

        $this->expectException(InvalidArgsException::class);
        $this->openWeatherController->getCurrentWeather(
            'cityNameValue',
            Mockery::mock(CommandBusInterface::class),
            Mockery::mock(GetCurrentWeatherEventListener::class)
        );
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function getCurrentWeatherOk(): void
    {
        $cityNameValidator = Mockery::mock('alias:' . CityNameValidator::class);
        $cityNameValidator->shouldReceive('validate')->once()->withArgs(['cityNameValue'])->andReturnTrue();

        $getCurrentWeatherEventListener = Mockery::mock(GetCurrentWeatherEventListener::class);
        $getCurrentWeatherEventListener->shouldReceive('getDataResponse')->twice()
            ->andReturn(['data' => 'dataResponse'])
        ;

        $commandBus = Mockery::mock(CommandBusInterface::class);
        $commandBus->shouldReceive('handle')->twice()
            ->withArgs(
                function (CommandInterface $command): bool {
                    if (!$command instanceof SaveWeatherCommand &&
                        !$command instanceof GetCurrentWeatherCommand
                    ) {
                        return false;
                    }

                    return true;
                }
            )
        ;

        $result = $this->openWeatherController->getCurrentWeather(
            'cityNameValue',
            $commandBus,
            $getCurrentWeatherEventListener
        );

        $this->assertEquals('dataResponse', \json_decode($result->getContent(), true)['data']);
    }
}
