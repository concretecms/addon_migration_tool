<?php

namespace PortlandLabs\Concrete5\MigrationTool\Entity\Import;

use Doctrine\ORM\EntityRepository;

class BatchRepository extends EntityRepository
{

    public function findBatchFromCollection(ObjectCollection $collection)
    {
        $query = $this->getEntityManager()->createQuery('select b from \PortlandLabs\Concrete5\MigrationTool\Entity\Import\Batch b inner join PortlandLabs\Concrete5\MigrationTool\Entity\Import\ObjectCollection o where o.id = :id');
        $query->setParameter('id', $collection->getID());
        return $query->getSingleResult();
    }


}