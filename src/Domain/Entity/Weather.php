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
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $dataJson;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $cityName;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDataJson(): string
    {
        return $this->dataJson;
    }

    /**
     * @param string $dataJson
     */
    public function setDataJson(string $dataJson): void
    {
        $this->dataJson = $dataJson;
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
