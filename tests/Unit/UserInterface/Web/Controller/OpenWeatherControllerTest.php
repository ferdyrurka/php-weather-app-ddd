<?php
declare(strict_types=1);

namespace App\Tests\Unit\UserInterface\Web\Controller;

use App\Application\Query\API\GetCurrentWeatherQuery;
use App\Domain\Command\SaveWeatherCommand;
use App\Domain\Exception\InvalidArgsException;
use App\UserInterface\Web\Controller\OpenWeatherController;
use App\UserInterface\Web\ViewObject\API\GetCurrentWeatherViewObject;
use Ferdyrurka\CommandBus\CommandBusInterface;
use Ferdyrurka\CommandBus\QueryBus;
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
    private OpenWeatherController $openWeatherController;

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
        $this->expectException(InvalidArgsException::class);
        $this->openWeatherController->getCurrentWeather(
            '&*&*&',
            Mockery::mock(CommandBusInterface::class),
            Mockery::mock(QueryBus::class)
        );
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function getCurrentWeatherOk(): void
    {
        $commandBus = Mockery::mock(CommandBusInterface::class);
        $commandBus->shouldReceive('handle')->once()
            ->withArgs([SaveWeatherCommand::class])
        ;

        $queryBus = Mockery::mock(QueryBus::class);
        $queryBus->shouldReceive('handle')->once()->withArgs([GetCurrentWeatherQuery::class])
            ->andReturn(new GetCurrentWeatherViewObject(['data' => 'dataResponse']))
        ;

        $result = $this->openWeatherController->getCurrentWeather(
            'cityNameValue',
            $commandBus,
            $queryBus
        );

        $this->assertEquals('dataResponse', \json_decode($result->getContent(), true)['data']);
    }
}
