<?php
declare(strict_types=1);

namespace App\Application\Query\Database;

use Ferdyrurka\CommandBus\Query\QueryInterface;

/**
 * Class GetOneByCityNameQuery
 * @package App\Application\Query
 * @codeCoverageIgnore
 */
class GetOneByCityNameQuery implements QueryInterface
{
    /**
     * @var string
     */
    private $cityName;

    /**
     * GetOneByCityNameQuery constructor.
     * @param string $cityName
     */
    public function __construct(string $cityName)
    {
        $this->cityName = $cityName;
    }

    /**
     * @return string
     */
    public function getCityName(): string
    {
        return $this->cityName;
    }
}
