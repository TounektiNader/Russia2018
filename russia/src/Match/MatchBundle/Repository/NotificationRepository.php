<?php
/**
 * Created by PhpStorm.
 * User: Nader
 * Date: 30/03/2018
 * Time: 12:52
 */

namespace Match\MatchBundle\Repository;


class NotificationRepository  extends \Doctrine\ORM\EntityRepository
{
    function notifcationGain($username)
    {
        $query=$this->getEntityManager()->createQuery(
            "select  count(m.id) as nb from MatchMatchBundle:Notifacation m WHERE m.username=:p AND m.etat=:c  AND m.titre=:d " )
            ->setParameter('p',$username)
            ->setParameter('c',0)
            ->setParameter('d','Gain');
        return $query->getResult();

    }

    function notifcationPerte($username)
    {
        $query=$this->getEntityManager()->createQuery(
            "select  count(m.id)as nb from MatchMatchBundle:Notifacation m WHERE m.username=:p AND m.etat=:c  AND m.titre=:d " )
            ->setParameter('p',$username)
            ->setParameter('c',0)
            ->setParameter('d','Perte');
        return $query->getResult();

    }

    function notifcation($username)
    {
        $query=$this->getEntityManager()->createQuery(
            "select  m from MatchMatchBundle:Notifacation m WHERE m.username=:p AND m.etat=:c  " )
            ->setParameter('p',$username)
            ->setParameter('c',0);

        return $query->getResult();

    }
}