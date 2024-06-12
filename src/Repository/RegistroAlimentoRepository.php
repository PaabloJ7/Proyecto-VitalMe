<?php



namespace App\Repository;

use App\Entity\RegistroAlimento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RegistroAlimentoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegistroAlimento::class);
    }

    public function findTotalCaloriasByUsuario($usuario): int
    {
        $totalCalorias = $this->createQueryBuilder('r')
            ->select('SUM(r.calorias)')
            ->andWhere('r.usuario = :usuario')
            ->setParameter('usuario', $usuario)
            ->getQuery()
            ->getSingleScalarResult();

     
        return $totalCalorias !== null ? (int) $totalCalorias : 0;
    }

    public function findByDateAndUser($usuario, $fecha): array
    {
        return $this->createQueryBuilder('ra')
            ->andWhere('ra.usuario = :usuario')
            ->andWhere('ra.fecha >= :fecha_inicio')
            ->andWhere('ra.fecha < :fecha_fin')
            ->setParameter('usuario', $usuario)
            ->setParameter('fecha_inicio', $fecha->format('Y-m-d 00:00:00')) 
            ->setParameter('fecha_fin', $fecha->format('Y-m-d 23:59:59')) 
            ->getQuery()
            ->getResult();
    }
}
