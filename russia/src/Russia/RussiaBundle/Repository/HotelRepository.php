<?php
/**
 * Created by PhpStorm.
 * User: Ouss'Hr
 * Date: 26/03/2018
 * Time: 11:27
 */

namespace Russia\RussiaBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Russia\RussiaBundle\Entity\Hotels;

class HotelRepository extends EntityRepository
{
    public function findSerieDQL($nom)
    {
        $query=$this->getEntityManager()
            ->createQuery("select v from RussiaRussiaBundle:Hotels v
WHERE v.nomhotel LIKE :nom
ORDER BY v.nomhotel ASC")
            ->setParameter('nom','%'.$nom.'%');
        return $query->getResult();
    }

    public function cafeville($nom)
    {
        $query=$this->getEntityManager()
            ->createQuery("select v from RussiaRussiaBundle:Hotels v, RussiaRussiaBundle:Villes c
WHERE v.idville = c.idville AND c.idville = :nom
ORDER BY v.nomhotel ASC")
            ->setParameter('nom',$nom->getIdville());
        return $query->getResult();
    }

    public function stadecafe()
    {
        $query=$this->getEntityManager()
            ->createQuery("select s from RussiaRussiaBundle:Hotels v, RussiaRussiaBundle:Stades s
WHERE v.idville = s.idville");
        return $query->getResult();
    }
}