<?php
/**
 * Created by PhpStorm.
 * User: Nader
 * Date: 26/03/2018
 * Time: 11:59
 */

namespace Match\MatchBundle\Repository;


class ResultatRepository extends \Doctrine\ORM\EntityRepository
{
    function findPartieEquipe($p)
    {
        $query=$this->getEntityManager()->createQuery(
            "select m from MatchMatchBundle:Resultat m WHERE m.idpartie=:p  " )->setParameter('p',$p);
        return $query->getResult();

    }

}