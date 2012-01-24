<?php

namespace Gpupo\CamelSpiderBundle\Entity;

use Doctrine\ORM\EntityRepository,
    CamelSpider\Entity\InterfaceLink,
    CamelSpider\Entity\Document;
/**
 * NewsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NewsRepository extends EntityRepository
{
    public function queryBuilder($limits = array('offset' => 0,'limit' => 50))
    {
        $qb = $this->createQueryBuilder('a');
        $qb->where('a.moderation = :moderation')
            ->add('orderBy', 'a.createdAt DESC')
            ->setFirstResult($limits['offset'])
            ->setMaxResults($limits['limit'])
            ->setParameters(array('moderation' => 'APROVED'));
        return $qb;
    }

    public function findLatest()
    {
        return $this->queryBuilder()->getQuery();
    }

    /**
     * Seleciona as notícias da categoria
     * e também da das subcategorias.
     * Também pode pesquisar fontes de notícias.
     *
     * @param string $type category|subscription
     * @return Doctrine query
     */
    public function findByType($type, $id)
    {
        $method = 'findBy' . $type . 'Id';

        return $this->$method($id);
    }

    /**
     * Especializado na pesquisa por fonte de conteúdo
     */
    public function findBySubscriptionId($id)
    {
        $q = $this->queryBuilder();
        $q->andWhere('a.subscription = :tid')
            ->setParameter('tid', $id);
        return $q->getQuery();
    }

    public function findByCategoryId($id)
    {

        $sq = $this->getEntityManager()->createQueryBuilder();
        $qb = clone $sq;
        $qb->from('Gpupo\CamelSpiderBundle\Entity\Category', 'd')
            ->select('d.id')
            ->add('where', $qb->expr()->orx(
                $qb->expr()
                    ->in('d.id', $this->subQuerySubCategories(clone $sq, $id, 'a')),
                $qb->expr()
                    ->in('d.parent', $this->subQuerySubCategories(clone $sq, $id, 'b'))
            ));

        $q = $this->queryBuilder();
        $q->andWhere(
            $q->expr()->orx(
                $q->expr()->eq('a.category' , $id),
                $q->expr()->in('a.category', $qb->getDQL())
            )
        );
        return $q->getQuery();
    }

    public function searchByKeyword($keyword)
    {
        $q = $this->queryBuilder();
        $q->andwhere($q->expr()->orx(
            $q->expr()->like('a.content', $q->expr()->literal('%' . $keyword . '%')),
            $q->expr()->like('a.title', $q->expr()->literal('%' . $keyword . '%'))
        ));

        return $q->getQuery();
    }


/* Atualização para Pager */

    public function readerQueryBuilder()
    {
        $qb = $this->createQueryBuilder('e')
                ->where('e.moderation = :moderation')
                ->setParameters(array('moderation' => 'APROVED'));
        return $qb;
    }

    /**
     * Seleciona as notícias da categoria
     * e também da das subcategorias.
     * Também pode pesquisar fontes de notícias.
     *
     * @param string $type category|subscription
     * @return Doctrine query
     */
    public function findByTypeQueryBuilder($type, $id)
    {
        $method = 'findBy' . $type . 'IdQueryBuilder';

        return $this->$method($id);
    }

    /**
     * Especializado na pesquisa por fonte de conteúdo
     */
    public function findBySubscriptionIdQueryBuilder($id)
    {
        $q = $this->readerQueryBuilder();
        $q->andWhere('e.subscription = :tid')
            ->setParameter('tid', $id);
        return $q;
    }

    public function findByCategoryIdQueryBuilder($id)
    {

        $sq = $this->getEntityManager()->createQueryBuilder();
        $qb = clone $sq;
        $qb->from('Gpupo\CamelSpiderBundle\Entity\Category', 'd')
            ->select('d.id')
            ->add('where', $qb->expr()->orx(
                $qb->expr()->in('d.id', $this->subQuerySubCategories(clone $sq, $id, 'a')),
                $qb->expr()->in('d.parent', $this->subQuerySubCategories(clone $sq, $id, 'b'))
            ));

        $q = $this->readerQueryBuilder();
        $q->andWhere(
            $q->expr()->orx(
                $q->expr()->eq('e.category' , $id),
                $q->expr()->in('e.category', $qb->getDQL())
            )
        );
        return $q;
    }

    private function subQuerySubCategories($qb, $id, $letter = null)
    {
        $letter = 'sb' . $letter;

        return $qb->from('Gpupo\CamelSpiderBundle\Entity\Category', $letter)
            ->select($letter . '.id')
            ->add('where', $qb->expr()->eq($letter . '.parent', $id))
            ->getDQL();
    }

    public function searchByKeywordQueryBuilder($keyword)
    {
        $q = $this->readerQueryBuilder();
        $q->andwhere($q->expr()->orx(
            $q->expr()->like('e.content', $q->expr()->literal('%' . $keyword . '%')),
            $q->expr()->like('e.title', $q->expr()->literal('%' . $keyword . '%'))
        ));

        return $q;
    }

    public function searchByLink(InterfaceLink $link)
    {
        $qb = $this->createQueryBuilder('a');
        $pars = array('href'    => $link->getHref());
        $document = $link->getDocument();
        $where = 'a.uri = :href';

        if ($document instanceof Document) {
            $where .= ' or a.title = :title or a.slug = :slug';
            $pars['slug']  = $document->getSlug();
            $pars['title'] = $document->getTitle();
        }

        $qb->where($where)->setParameters($pars);

        return $qb;
    }

    public function countByLink(InterfaceLink $link)
    {

        $r = $this->searchByLink($link)
            ->getQuery()
            ->getArrayResult();

        return is_null($r) ? 0 : count($r);
    }


}
