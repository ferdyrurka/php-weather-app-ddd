<?php
declare(strict_types=1);

namespace App\Domain\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class WeatherNotFoundException
 * @package App\Domain\Exception
 */
class WeatherNotFoundException extends NotFoundHttpException
{
}
