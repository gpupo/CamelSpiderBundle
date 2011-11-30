<?php

namespace Gpupo\CamelSpiderBundle\Entity;

use Doctrine\ORM\EntityRepository,
    Gpupo\CamelSpiderReaderBundle\Entity\InterfaceNode;

use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends NestedTreeRepository implements InterfaceNode
{
    public function findForMenu()
    {

        return $this->findForList()->getQuery()->getResult();
    }

    public function findForList()
    {
        $qb = $this->createQueryBuilder('e');
        $qb->where('e.parent IS NOT NULL')
            ->add('orderBy', 'e.lft ASC');

        return $qb;
    }

    public function removeAndMoveRelated(Category $removedCategory, $movedCategory)
    {
        // Moving related Subscritions
        $qb1 = $this->getEntityManager()->createQueryBuilder();
        $qb1->update('Gpupo\CamelSpiderBundle\Entity\Subscription s')
            ->set('s.category', '?1')
            ->add('where', $qb1->expr()->eq('s.category', '?2'))
            ->setParameter(1, $movedCategory)
            ->setParameter(2, $removedCategory->getId())
            ->getQuery()->getResult();

        $qb2 = $this->getEntityManager()->createQueryBuilder();
        $qb2->update('Gpupo\CamelSpiderBundle\Entity\News n')
            ->set('n.category', '?1')
            ->add('where', $qb2->expr()->eq('n.category', '?2'))
            ->setParameter(1, $movedCategory)
            ->setParameter(2, $removedCategory->getId())
            ->getQuery()->getResult();

        $this->getEntityManager()->remove($removedCategory);
        $this->getEntityManager()->flush();
    }
}
