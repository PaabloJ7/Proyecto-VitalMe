<?php


namespace App\Repository;

use App\Entity\Publicacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PublicacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Publicacion::class);
    }

    /**

     *
     * @param int $limit La cantidad máxima de publicaciones destacadas a recuperar
     * @return Publicacion[] Un array de objetos Publicacion
     */
    public function findDestacadasOrderByLikes($limit): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.likes', 'DESC') // Ordenar por cantidad de likes en orden descendente
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findLatest($limit): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
