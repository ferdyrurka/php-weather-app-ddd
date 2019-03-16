<?php
declare(strict_types=1);

namespace App\UserInterface\Web\Controller;

use App\Domain\Command\GetCurrentWeatherCommand;
use App\Domain\Command\SaveWeatherCommand;
use App\Domain\Event\GetCurrentWeatherEventListener;
use App\Domain\Exception\InvalidArgsException;
use App\Domain\Validator\CityNameValidator;
use Ferdyrurka\CommandBus\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class OpenWeatherController
 * @package App\UserInterface\Web\Controller
 * @Route("/api/v1")
 */
class OpenWeatherController extends AbstractController
{
    /**
     * @param string $cityName
     * @param CommandBusInterface $commandBus
     * @param GetCurrentWeatherEventListener $currentWeatherEventListener
     * @return Response
     * @Route("/get-current-weather/{cityName}", methods={"GET"})
     */
    public function getCurrentWeather(
        string $cityName,
        CommandBusInterface $commandBus,
        GetCurrentWeatherEventListener $currentWeatherEventListener
    ): Response {
        if (CityNameValidator::validate($cityName)) {
            $cityName = strtolower($cityName);

            $getCurrentWeatherCommand = new GetCurrentWeatherCommand($cityName);
            $commandBus->handle($getCurrentWeatherCommand);

            $saveWeatherCommand = new SaveWeatherCommand($cityName, $currentWeatherEventListener->getDataResponse());
            $commandBus->handle($saveWeatherCommand);

            return new Response(
                \json_encode($currentWeatherEventListener->getDataResponse(), JSON_UNESCAPED_UNICODE),
                200,
                ['Content-Type' => 'application/json; charset=utf-8']
            );
        }

        throw new InvalidArgsException('City name (' . $cityName . ') is invalid');
    }
}
