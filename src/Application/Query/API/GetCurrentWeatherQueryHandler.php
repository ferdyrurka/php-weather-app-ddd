<?php
declare(strict_types=1);

namespace App\Application\Query\API;

use App\Domain\OWM\WeatherOWMRepositoryInterface;
use App\UserInterface\Web\ViewObject\API\GetCurrentWeatherViewObject;
use Ferdyrurka\CommandBus\Query\Handler\QueryHandlerInterface;
use Ferdyrurka\CommandBus\Query\QueryInterface;
use Ferdyrurka\CommandBus\Query\ViewObject\ViewObjectInterface;

/**
 * Class GetCurrentWeatherCommandHandler
 * @package App\Domain\Command
 */
class GetCurrentWeatherQueryHandler implements QueryHandlerInterface
{
    /**
     * @var WeatherOWMRepositoryInterface
     */
    private WeatherOWMRepositoryInterface $weatherOWMRepository;

    /**
     * GetCurrentWeatherCommandHandler constructor.
     * @param WeatherOWMRepositoryInterface $WeatherOWMRepository
     */
    public function __construct(WeatherOWMRepositoryInterface $WeatherOWMRepository)
    {
        $this->weatherOWMRepository = $WeatherOWMRepository;
    }

    /**
     * @param QueryInterface $query
     * @return ViewObjectInterface
     */
    public function handle(QueryInterface $query): ViewObjectInterface
    {
        $weather = $this->weatherOWMRepository->getOneByCityName($query->getCityName());

        return new GetCurrentWeatherViewObject(
            $weather
        );
    }
}
