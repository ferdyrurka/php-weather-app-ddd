<?php
declare(strict_types=1);

namespace App\Tests\Unit\Domain\Validator;

use App\Domain\Validator\CityNameValidator;
use PHPUnit\Framework\TestCase;

/**
 * Class CityNameValidatorTest
 * @package App\Tests\Unit\Domain\Validator
 */
class CityNameValidatorTest extends TestCase
{
    /**
     * @test
     */
    public function validateOk(): void
    {
        $this->assertTrue(CityNameValidator::validate('Wąchock'));
    }

    /**
     * @test
     */
    public function validateFailed(): void
    {
        $this->assertFalse(CityNameValidator::validate('LONDON_FAILED_1'));
    }
}
