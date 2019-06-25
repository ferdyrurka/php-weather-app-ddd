<?php
declare(strict_types=1);

namespace App\UserInterface\Web\Controller;

use App\Application\Query\API\GetCurrentWeatherQuery;
use App\Domain\Command\SaveWeatherCommand;
use App\Domain\Exception\InvalidArgsException;
use App\Domain\Validator\CityNameValidator;
use Ferdyrurka\CommandBus\CommandBusInterface;
use Ferdyrurka\CommandBus\QueryBus;
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
     * @param QueryBus $queryBus
     * @return Response
     * @throws \Ferdyrurka\CommandBus\Exception\QueryHandlerNotFoundException
     * @Route("/get-current-weather/{cityName}", methods={"GET"})
     */
    public function getCurrentWeather(
        string $cityName,
        CommandBusInterface $commandBus,
        QueryBus $queryBus
    ): Response {
        if (CityNameValidator::validate($cityName)) {
            $cityName = strtolower($cityName);

            $getCurrentWeatherQuery = new GetCurrentWeatherQuery($cityName);
            $getCurrentWeatherViewObject = $queryBus->handle($getCurrentWeatherQuery);

            $saveWeatherCommand = new SaveWeatherCommand($cityName, $getCurrentWeatherViewObject->getData());
            $commandBus->handle($saveWeatherCommand);

            return new Response(
                \json_encode($getCurrentWeatherViewObject->getData(), JSON_UNESCAPED_UNICODE),
                200,
                ['Content-Type' => 'application/json; charset=utf-8']
            );
        }

        throw new InvalidArgsException('City name (' . $cityName . ') is invalid');
    }
}
