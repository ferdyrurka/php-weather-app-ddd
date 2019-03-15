<?php
declare(strict_types=1);

namespace App\Domain\Exception;

/**
 * Class InvalidArgsException
 * @package App\Domain\Exception
 */
class InvalidArgsException extends WeatherAppException
{
    /**
     * InvalidArgsException constructor.
     * @param string|null $message
     */
    public function __construct(?string $message = null)
    {
        parent::__construct($message, 409);
    }
}
