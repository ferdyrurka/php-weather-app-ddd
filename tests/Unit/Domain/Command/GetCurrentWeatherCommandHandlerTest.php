<?php
declare(strict_types=1);

namespace App\Tests\Unit\Domain\Command;

use App\Domain\Command\GetCurrentWeatherCommand;
use App\Domain\Command\GetCurrentWeatherCommandHandler;
use App\Domain\Event\GetCurrentWeatherEvent;
use App\Domain\Exception\ServerOWMException;
use App\Domain\Exception\WeatherNotFoundException;
use App\Infrastructure\OWM\WeatherOWMRepository;
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
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var WeatherOWMRepository
     */
    private $weatherOWMRepository;

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
        $this->weatherOWMRepository = Mockery::mock(WeatherOWMRepository::class);

        $this->eventDispatcher = Mockery::mock(EventDispatcherInterface::class);
        $this->getCurrentWeatherCommandHandler = new GetCurrentWeatherCommandHandler(
            $this->weatherOWMRepository,
            $this->eventDispatcher
        );
    }

    /**
     * @test
     */
    public function handleOk(): void
    {
        $this->weatherOWMRepository->shouldReceive('getOneByCityName')->once()->andReturn(['result' => true])
            ->withArgs(['Warsaw'])
        ;

        $this->eventDispatcher->shouldReceive('dispatch')->once()
            ->withArgs([GetCurrentWeatherEvent::NAME, GetCurrentWeatherEvent::class])
        ;

        $this->getCurrentWeatherCommandHandler->handle($this->getCurrentWeatherCommand);
    }
}
