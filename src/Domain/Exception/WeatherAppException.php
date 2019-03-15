<?php
declare(strict_types=1);

namespace App\Domain\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class WheatherAppException
 * @package App\Domain\Exception
 */
class WeatherAppException extends HttpException
{
    /**
     * WeatherAppException constructor.
     * @param string|null $message
     * @param int $statusCode
     */
    public function __construct(string $message = null, int $statusCode = 500)
    {
        parent::__construct($statusCode, $message);
    }
}
