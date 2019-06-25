<?php
declare(strict_types=1);

namespace App\Domain\Command;

use App\Domain\Repository\WeatherRepositoryInterface;
use Ferdyrurka\CommandBus\Command\CommandInterface;
use Ferdyrurka\CommandBus\Handler\HandlerInterface;

/**
 * Class SaveWeatherCommandHandler
 * @package App\Domain\Command
 */
class SaveWeatherCommandHandler implements HandlerInterface
{
    /**
     * @var WeatherRepositoryInterface
     */
    private WeatherRepositoryInterface $weatherRepository;

    /**
     * SaveWeatherCommandHandler constructor.
     * @param WeatherRepositoryInterface $weatherRepository
     */
    public function __construct(WeatherRepositoryInterface $weatherRepository)
    {
        $this->weatherRepository = $weatherRepository;
    }

    /**
     * @param CommandInterface $command
     */
    public function handle(CommandInterface $command): void
    {
        $weather = $this->weatherRepository->findOneByCityName($command->getCityName());
        $weather->setData($command->getResponseData());
        $this->weatherRepository->save($weather);
    }
}
