<?php
declare(strict_types=1);

namespace App\Domain\Validator;

/**
 * Class CityNameValidator
 * @package App\Domain\Validator
 */
class CityNameValidator implements ValidatorInterface
{
    /**
     * @param $value
     * @return bool
     */
    public static function validate($value): bool
    {
        if (!preg_match('/^([A-ZĄĆĘŁŃÓŚŹŻ|a-ząćęłnóśźż]){1,64}$/', $value)) {
            return false;
        }

        return true;
    }
}
