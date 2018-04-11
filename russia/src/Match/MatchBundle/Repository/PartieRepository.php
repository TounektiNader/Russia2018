<?php
/**
 * Created by PhpStorm.
 * User: Nader
 * Date: 20/03/2018
 * Time: 12:11
 */

namespace Match\MatchBundle\Repository;


class PartieRepository extends \Doctrine\ORM\EntityRepository
{

    public function selectDQL(){
        $querry = $this->getEntityManager()->createQuery("select DISTINCT m.groupe from MatchMatchBundle:Partie m ");
        return $querry->getResult();
    }

    function nombrePartieGroupe($groupe)
    {
        $query=$this->getEntityManager()->createQuery(
            "select COUNT (m.id) as nb from MatchMatchBundle:Partie m WHERE m.groupe LIKE :p and m.etatmatch LIKE :c " )
            ->setParameter('p','%'.$groupe.'%')
            ->setParameter('c','Jouee');
        return $query->getResult();

    }

    function findPartie($p)
    {
        $query=$this->getEntityManager()->createQuery(
            "select m from MatchMatchBundle:Partie m WHERE m.etiquette LIKE :p " )->setParameter('p',$p);
        return $query->getResult();

    }

    function findPartieEquipe($p)
    {
        $query=$this->getEntityManager()->createQuery(
            "select m from MatchMatchBundle:Partie m WHERE m.home=:p  OR  m.away=:p" )->setParameter('p',$p);
        return $query->getResult();

    }

    function lastParties()
    {
        $query=$this->getEntityManager()->createQuery(
            "select m from MatchMatchBundle:Partie m WHERE m.etatmatch LIKE :p ORDER By m.datepartie  " )
            ->setParameter('p','PasEncore');

        return $query->getResult();

    }

    function ProchainMatch()
    {
        $query=$this->getEntityManager()->createQuery(
            "select m from MatchMatchBundle:Partie m WHERE m.etatmatch LIKE :p ORDER By m.datepartie  " )
            ->setParameter('p','PasEncore');

        return $query->getResult();

    }

    function lastPartiesJouee()
    {
        $query=$this->getEntityManager()->createQuery(
            "select m from MatchMatchBundle:Partie m WHERE m.etatmatch LIKE :p ORDER By m.datepartie ASC " )
            ->setParameter('p','Jouee');

        return $query->getResult();

    }
}