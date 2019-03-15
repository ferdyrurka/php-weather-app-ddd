<?php
declare(strict_types=1);

namespace App\Tests\Application\Query;

use App\Application\Query\GetOneByCityNameQuery;
use App\Application\Query\GetOneByCityNameQueryHandler;
use App\Domain\Entity\Weather;
use App\Domain\Repository\WeatherRepositoryInterface;
use App\UserInterface\Web\ViewObject\GetOneByCityNameViewObject;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * Class GetOneByCityNameQueryHandlerTest
 * @package App\Tests\Application\Query
 */
class GetOneByCityNameQueryHandlerTest extends TestCase
{
    /**
     * @var WeatherRepositoryInterface
     */
    private $weatherRepository;

    /**
     * @var GetOneByCityNameQueryHandler
     */
    private $getOneByCityNameQueryHandler;

    /**
     *
     */
    protected function setUp(): void
    {
        $this->weatherRepository = Mockery::mock(WeatherRepositoryInterface::class);

        $this->getOneByCityNameQueryHandler = new GetOneByCityNameQueryHandler($this->weatherRepository);
    }

    /**
     * @test
     */
    public function handleOk(): void
    {
        $weather = Mockery::mock(Weather::class);
        $weather->shouldReceive('getData')->once()->andReturn(['data' => 'arrayData']);

        $this->weatherRepository->shouldReceive('getOneByCityName')->once()->withArgs(['cityNameValue'])
            ->andReturn($weather)
        ;

        $query = Mockery::mock(GetOneByCityNameQuery::class);
        $query->shouldReceive('getCityName')->once()->andReturn('cityNameValue');

        $result = $this->getOneByCityNameQueryHandler->handle($query);

        $this->assertInstanceOf(GetOneByCityNameViewObject::class, $result);
        $this->assertEquals('arrayData', $result->getData()['data']);
    }
}
