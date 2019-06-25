<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Weather
 * @package App\Domaind\Entity
 * @ORM\Entity
 * @ORM\Table(name="weather")
 */
class Weather
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", length=11)
     */
    private int $id;

    /**
     * @var array
     * @ORM\Column(type="array")
     */
    private array $data;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true, length=64)
     */
    private string $cityName;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getCityName(): string
    {
        return $this->cityName;
    }

    /**
     * @param string $cityName
     */
    public function setCityName(string $cityName): void
    {
        $this->cityName = $cityName;
    }
}
