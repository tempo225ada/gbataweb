<?php

namespace AppBundle\Repository;

use AppBundle\Entity\ImmobilierSearch;

/**
 * ImmobilierRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ImmobilierRepository extends \Doctrine\ORM\EntityRepository
{
   public function findAllImmobilier(ImmobilierSearch $search){

       $query = $this->createQueryBuilder('u');
        
       if($search->getType()){
            $query->andWhere('u.type = :type')
                  ->setParameter('type', $search->getType());
       }

       if($search->getBien()){
            $query->andWhere('u.bien = :bien')
                  ->setParameter('bien', $search->getBien());
        }

        if($search->getTypebien()){
            $query->andWhere('u.typebien = :typebien')
                  ->setParameter('typebien', $search->getTypebien());
        }

        if($search->getCommune()){
            $query->andWhere('u.commune = :commune')
                  ->setParameter('commune', $search->getCommune());
        }

        if($search->getPiece()){
            $query->andWhere('u.piece = :piece')
                  ->setParameter('piece', $search->getPiece());
        }

        if($search->getPrix()){
            $query->andWhere('u.prix <= :prix')
                  ->setParameter('prix', $search->getPrix());
        }
        $query->addOrderBy('u.datecreation', 'DESC');
        return $query->getQuery();
    }

}

