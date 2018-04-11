<?php
/**
 * Created by PhpStorm.
 * User: Ouss'Hr
 * Date: 26/03/2018
 * Time: 11:27
 */

namespace Russia\RussiaBundle\Repository;
use Doctrine\ORM\EntityRepository;
use Russia\RussiaBundle\Entity\Cafes;

class VilleRepository extends EntityRepository
{
    public function findSerieDQL($nom)
    {
        $query=$this->getEntityManager()
            ->createQuery("select v from RussiaRussiaBundle:Villes v
WHERE v.nomville LIKE :nom
ORDER BY v.nomville ASC")
            ->setParameter('nom','%'.$nom.'%');
        return $query->getResult();
    }

    public function cafeville($nom)
    {
        $query=$this->getEntityManager()
            ->createQuery("select v from RussiaRussiaBundle:Cafes v, RussiaRussiaBundle:Villes c
WHERE v.idville = c.idville AND c.idville = :nom
ORDER BY v.nomcafe ASC")
            ->setParameter('nom',$nom);
        return $query->getResult();
    }

    public function hotelville($nom)
    {
        $query=$this->getEntityManager()
            ->createQuery("select v from RussiaRussiaBundle:Hotels v, RussiaRussiaBundle:Villes c
WHERE v.idville = c.idville AND c.idville = :nom
ORDER BY v.nomhotel ASC")
            ->setParameter('nom',$nom);
        return $query->getResult();
    }

    public function restoville($nom)
    {
        $query=$this->getEntityManager()
            ->createQuery("select v from RussiaRussiaBundle:Restos v, RussiaRussiaBundle:Villes c
WHERE v.idville = c.idville AND c.idville = :nom
ORDER BY v.nomresto ASC")
            ->setParameter('nom',$nom);
        return $query->getResult();
    }

    public function stadeville($nom)
    {
        $query=$this->getEntityManager()
            ->createQuery("select v from RussiaRussiaBundle:Stades v, RussiaRussiaBundle:Villes c
WHERE v.idville = c.idville AND c.idville = :nom
ORDER BY v.nomstade ASC")
            ->setParameter('nom',$nom);
        return $query->getResult();
    }

}