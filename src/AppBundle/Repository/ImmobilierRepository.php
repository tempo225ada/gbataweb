<?php

namespace AppBundle\Repository;

/**
 * ImmobilierRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ImmobilierRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllImmobilier(){
        return $this->getEntitymanager()
            ->createQuery(
                'SELECT i FROM AppBundle:Immobilier i ORDER by i.datecreation DESC'
            )
            ->getResult();
    }
}
