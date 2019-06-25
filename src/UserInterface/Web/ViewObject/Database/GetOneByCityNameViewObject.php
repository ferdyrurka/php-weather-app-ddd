<?php
declare(strict_types=1);

namespace App\UserInterface\Web\ViewObject\Database;

use Ferdyrurka\CommandBus\Query\ViewObject\ViewObjectInterface;

/**
 * Class GetOneByCityNameViewObject
 * @package App\UserInterface\Web\ViewObject
 */
class GetOneByCityNameViewObject implements ViewObjectInterface
{
    /**
     * @var array
     */
    private $data;

    /**
     * GetOneByCityNameViewObject constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
