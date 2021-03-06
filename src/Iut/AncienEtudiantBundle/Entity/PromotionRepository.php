<?php

namespace Iut\AncienEtudiantBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * PromotionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PromotionRepository extends EntityRepository
{
    public function  getById($id){
        $query = $this->createQueryBuilder('p')
                      ->where('p.id = :id')
                      ->setParameter('id', $id);
         return $query->getQuery()
                      ->getArrayResult();
    }
    
}
