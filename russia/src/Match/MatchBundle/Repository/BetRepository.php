<?php
/**
 * Created by PhpStorm.
 * User: Nader
 * Date: 25/03/2018
 * Time: 11:17
 */

namespace Match\MatchBundle\Repository;


class BetRepository extends \Doctrine\ORM\EntityRepository
{
    function nombreMatchJouer($username,$idPartie)
    {
        $query=$this->getEntityManager()->createQuery(
            "select COUNT (m.idbet) as nb from MatchMatchBundle:Bet m WHERE m.username=:p and m.idpartie=:c " )
            ->setParameter('p',$username)
            ->setParameter('c',$idPartie);
        return $query->getResult();

    }


    function nombreUser()
    {
        $query=$this->getEntityManager()->createQuery(
            "select COUNT (m.id) as nb from MatchMatchBundle:User  " )
            ;
        return $query->getResult();

    }




    function nombreCadeaux()
    {
        $query=$this->getEntityManager()->createQuery(
            "select COUNT (m.idcadeau) as nb from RussiaRussiaBundle:Cadeau  " )
        ;
        return $query->getResult();

    }





    function nombreParties()
    {
        $query=$this->getEntityManager()->createQuery(
            "select COUNT (m.id) as nb from MatchMatchBundle:Partie  " )
        ;
        return $query->getResult();

    }


    function mesBets($username)
    {
        $query=$this->getEntityManager()->createQuery(
            "select m  from MatchMatchBundle:Bet m WHERE m.username=:p  " )
            ->setParameter('p',$username);

        return $query->getResult();

    }




    function countbetPerduBets()
    {
        $query=$this->getEntityManager()->createQuery(
            "select m , count(m.idbet)  as nb  from MatchMatchBundle:Bet m WHERE m.etat=:c  GROUP  BY m.username ORDER by m.username " )

            ->setParameter('c','Perte');

        return $query->getResult();

    }
    function countbetgagneBets()
    {
        $query=$this->getEntityManager()->createQuery(
            "select m,count(m.idbet)  as nb  from MatchMatchBundle:Bet m WHERE m.etat=:c  GROUP  BY m.username ORDER by m.username " )

            ->setParameter('c','Gain');

        return $query->getResult();

    }


    function DistancBets()
    {
        $query=$this->getEntityManager()->createQuery(
            "select m from MatchMatchBundle:Bet m  GROUP  BY m.username ORDER by m.username   " )    ;

        return $query->getResult();

    }





}