<?php
declare(strict_types=1);


namespace App\Infrastructure\Repository;

use App\Domain\Entity\Weather;
use App\Domain\Exception\WeatherNotFoundException;
use App\Domain\Repository\WeatherRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class WeatherRepository
 * @package App\Infrastructure\Repository
 */
class WeatherRepository extends ServiceEntityRepository implements WeatherRepositoryInterface
{
    /**
     * WeatherRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Weather::class);
    }

    /**
     * @param string $cityName
     * @return Weather
     */
    public function getOneByCityName(string $cityName): Weather
    {
        $weather = $this
            ->createQueryBuilder('p')
            ->where('p.cityName = :cityName')
            ->setParameter(':cityName', $cityName)
            ->setMaxResults(1)
            ->getQuery()
            ->execute()
        ;

        if (empty($weather)) {
            throw new WeatherNotFoundException('Weather by city name: ' . $cityName . ' is not found');
        }

        return $weather[0];
    }

    /**
     * @param string $cityName
     * @return Weather|null
     */
    public function findOneByCityName(string $cityName): ?Weather
    {
        $weather = $this
            ->createQueryBuilder('p')
            ->where('p.cityName = :cityName')
            ->setParameter(':cityName', $cityName)
            ->setMaxResults(1)
            ->getQuery()
            ->execute()
        ;

        if (empty($weather)) {
            return null;
        }

        return $weather[0];
    }

    /**
     * @param Weather $weather
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Weather $weather): void
    {
        $em = $this->getEntityManager();
        $em->persist($weather);
        $em->flush();
    }
}
