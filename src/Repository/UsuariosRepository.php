<?php

namespace App\Repository;

use App\Entity\Usuarios;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UsuariosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuarios::class);
    }

    /**
     * 
     *
     * @param string $searchTerm El término de búsqueda
     * @return Usuarios[] Un arreglo de usuarios que coinciden con el término de búsqueda
     */
    public function findByUsernameOrEmail(string $searchTerm): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username LIKE :searchTerm OR u.email LIKE :searchTerm')
            ->setParameter('searchTerm', '%'.$searchTerm.'%')
            ->getQuery()
            ->getResult();
    }
}
