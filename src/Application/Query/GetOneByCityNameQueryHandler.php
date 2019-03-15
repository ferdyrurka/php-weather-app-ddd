<?php
declare(strict_types=1);

namespace App\Application\Query;

use App\Domain\Repository\WeatherRepositoryInterface;
use App\UserInterface\Web\ViewObject\GetOneByCityNameViewObject;
use Ferdyrurka\CommandBus\Query\Handler\QueryHandlerInterface;
use Ferdyrurka\CommandBus\Query\QueryInterface;
use Ferdyrurka\CommandBus\Query\ViewObject\ViewObjectInterface;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

/**
 * Class GetOneByCityNameQueryHandler
 * @package App\Application\Query
 */
class GetOneByCityNameQueryHandler implements QueryHandlerInterface
{
    use MockeryPHPUnitIntegration;

    /**
     * @var WeatherRepositoryInterface
     */
    private $weatherRepository;

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
