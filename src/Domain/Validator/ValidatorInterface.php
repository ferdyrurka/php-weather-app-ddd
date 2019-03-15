<?php
declare(strict_types=1);

namespace App\Domain\Validator;

/**
 * Interface ValidatorInterface
 * @package App\Domain\Validator
 */
interface ValidatorInterface
{
    /**
     * @param $value
     * @return bool
     */
    public static function validate($value): bool;
}
