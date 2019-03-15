<?php
declare(strict_types=1);

namespace App\UserInterface\Web\Controller;

use App\Application\Query\GetOneByCityNameQuery;
use App\Domain\Exception\InvalidArgsException;
use App\Domain\Validator\CityNameValidator;
use Ferdyrurka\CommandBus\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DatabaseController
 * @package App\UserInterface\Web\Controller
 * @Route("/api/v1")
 */
class DatabaseController extends AbstractController
{
    /**
     * @param string $cityName
     * @param QueryBusInterface $queryBus
     * @throws InvalidArgsException
     * @return JsonResponse
     * @Route("/get-last-save-weather/{cityName}")
     */
    public function getLastSaveWeather(string $cityName, QueryBusInterface $queryBus): JsonResponse
    {
        if (CityNameValidator::validate($cityName)) {
            $getOneByCityNameQuery = new GetOneByCityNameQuery($cityName);
            $getOneByCityNameViewObject = $queryBus->handle($getOneByCityNameQuery);

            return new JsonResponse($getOneByCityNameViewObject->getData());
        }

        throw new InvalidArgsException('City name (' . $cityName . ') is invalid');
    }
}
