<?php
declare(strict_types=1);

namespace App\Tests\Unit\UserInterface\Web\Controller;

use App\Application\Query\GetOneByCityNameQuery;
use App\Domain\Exception\InvalidArgsException;
use App\Domain\Validator\CityNameValidator;
use App\UserInterface\Web\Controller\DatabaseController;
use App\UserInterface\Web\ViewObject\GetOneByCityNameViewObject;
use Ferdyrurka\CommandBus\QueryBusInterface;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * Class DatabaseControllerTest
 * @package App\Tests\Unit\UserInterface\Web\Controller
 */
class DatabaseControllerTest extends TestCase
{
    use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

    /**
     * @var DatabaseController
     */
    private $databaseController;

    /**
     * @var QueryBusInterface
     */
    private $queryBus;

    /**
     *
     */
    protected function setUp(): void
    {
        $this->queryBus = Mockery::mock(QueryBusInterface::class);

        $this->databaseController = new DatabaseController();
    }


    /**
     * @test
     * @runInSeparateProcess
     */
    public function getLastSaveWeatherInvalidData(): void
    {
        $cityNameValidator = Mockery::mock('alias:' . CityNameValidator::class);
        $cityNameValidator->shouldReceive('validate')->withArgs(['London'])->once()->andReturnFalse();

        $this->expectException(InvalidArgsException::class);
        $this->databaseController->getLastSaveWeather('London', $this->queryBus);
    }

    /**
     * @test
     * @runInSeparateProcess
     */
    public function getLastSaveWeatherOk(): void
    {
        $cityNameValidator = Mockery::mock('alias:' . CityNameValidator::class);
        $cityNameValidator->shouldReceive('validate')->withArgs(['London'])->once()->andReturnTrue();

        $viewObject = Mockery::mock(GetOneByCityNameViewObject::class);
        $viewObject->shouldReceive('getData')->once()->andReturn(['data' => 'data_from_database']);

        $this->queryBus->shouldReceive('handle')->once()->andReturn($viewObject)
            ->withArgs(
                function (object $query): bool {
                    if (!$query instanceof GetOneByCityNameQuery ||
                        $query->getCityName() !== 'london'
                    ) {
                        return false;
                    }

                    return true;
                }
            )
        ;

        $result = $this->databaseController->getLastSaveWeather('London', $this->queryBus);
        $this->assertEquals(200, $result->getStatusCode());
        $this->assertEquals('data_from_database', \json_decode($result->getContent(), true)['data']);
    }
}
