<?php
/**
 * Created by PhpStorm.
 * User: Amouri Aziz
 * Date: 13/04/2018
 * Time: 02:58
 */

namespace Equipe\EquipeBundle\Repository;


class EquipeRepository extends \Doctrine\ORM\EntityRepository
{
    public function rechercheAction($word)
    {
        $qb= $this->getEntityManager()->createQueryBuilder();
        $qb->select('E')
            ->from('EquipeEquipeBundle:Equipe', 'E')
            ->where('E.nomequipe LIKE :word')
            ->setParameter('word', '%'.$word.'%');
        $q = $qb->getQuery();
        return $q->execute();
    }
}