<?php
declare(strict_types=1);

namespace App\Domain\Command;

use App\Application\Factory\CreateWeatherFactory;
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
    private $weatherRepository;

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

        if ($weather === null) {
            $factory = new CreateWeatherFactory($command->getResponseData(), $command->getCityName());
            $weather = $factory->getWeather();
        } else {
            $weather->setData($command->getResponseData());
        }

        $this->weatherRepository->save($weather);
    }
}
