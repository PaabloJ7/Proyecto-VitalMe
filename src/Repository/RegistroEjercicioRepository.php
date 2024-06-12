<?php

namespace App\Repository;

use App\Entity\RegistroEjercicio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DateTime;

class RegistroEjercicioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegistroEjercicio::class);
    }

    public function findByDateAndUser($user, DateTime $date)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.usuario = :user')
            ->andWhere('r.fecha >= :start')
            ->andWhere('r.fecha < :end')
            ->setParameter('user', $user)
            ->setParameter('start', $date->format('Y-m-d 00:00:00'))
            ->setParameter('end', $date->format('Y-m-d 23:59:59'))
            ->orderBy('r.fecha', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
