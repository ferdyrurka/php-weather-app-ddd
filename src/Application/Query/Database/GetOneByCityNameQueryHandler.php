<?php
declare(strict_types=1);

namespace App\Application\Query\Database;

use App\Domain\Repository\WeatherRepositoryInterface;
use App\UserInterface\Web\ViewObject\Database\GetOneByCityNameViewObject;
use Ferdyrurka\CommandBus\Query\Handler\QueryHandlerInterface;
use Ferdyrurka\CommandBus\Query\QueryInterface;
use Ferdyrurka\CommandBus\Query\ViewObject\ViewObjectInterface;

/**
 * Class GetOneByCityNameQueryHandler
 * @package App\Application\Query
 */
class GetOneByCityNameQueryHandler implements QueryHandlerInterface
{
    /**
     * @var WeatherRepositoryInterface
     */
    private WeatherRepositoryInterface $weatherRepository;

    /**
     * GetOneByCityNameQueryHandler constructor.
     * @param WeatherRepositoryInterface $weatherRepository
     */
    public function __construct(WeatherRepositoryInterface $weatherRepository)
    {
        $this->weatherRepository = $weatherRepository;
    }

    /**
     * @param QueryInterface $query
     * @return ViewObjectInterface
     */
    public function handle(QueryInterface $query): ViewObjectInterface
    {
        $weather = $this->weatherRepository->getOneByCityName($query->getCityName());

        return new GetOneByCityNameViewObject(
            $weather->getData()
        );
    }
}
