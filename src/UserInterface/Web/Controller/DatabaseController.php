<?php
declare(strict_types=1);

namespace App\UserInterface\Web\Controller;

use App\Application\Query\GetOneByCityNameQuery;
use App\Domain\Exception\InvalidArgsException;
use App\Domain\Validator\CityNameValidator;
use Ferdyrurka\CommandBus\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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
     * @return Response
     * @Route("/get-last-save-weather/{cityName}", methods={"GET"})
     */
    public function getLastSaveWeather(string $cityName, QueryBusInterface $queryBus): Response
    {
        if (CityNameValidator::validate($cityName)) {
            $cityName = strtolower($cityName);

            $getOneByCityNameQuery = new GetOneByCityNameQuery($cityName);
            $getOneByCityNameViewObject = $queryBus->handle($getOneByCityNameQuery);

            return new Response(
                \json_encode($getOneByCityNameViewObject->getData(), JSON_UNESCAPED_UNICODE),
                200,
                ['Content-Type' => 'application/json; charset=utf-8']
            );
        }

        throw new InvalidArgsException('City name (' . $cityName . ') is invalid');
    }
}
