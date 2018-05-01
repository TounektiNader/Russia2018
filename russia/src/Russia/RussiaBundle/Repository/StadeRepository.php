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
use Russia\RussiaBundle\Entity\Cafes;

class StadeRepository extends EntityRepository
{
    public function findSerieDQL($nom)
    {
        $query=$this->getEntityManager()
            ->createQuery("select v from RussiaRussiaBundle:Stades v
WHERE v.nomstade LIKE :nom
ORDER BY v.nomstade ASC")
            ->setParameter('nom','%'.$nom.'%');
        return $query->getResult();
    }

    public function cafeville($nom)
    {
        $query=$this->getEntityManager()
            ->createQuery("select v from RussiaRussiaBundle:Stades v, RussiaRussiaBundle:Villes c
WHERE v.idville = c.idville AND c.idville = :nom
ORDER BY v.nomstade ASC")
            ->setParameter('nom',$nom->getIdville());
        return $query->getResult();
    }

    public function stadecafe($nom)
    {
        $query=$this->getEntityManager()
            ->createQuery("select s from RussiaRussiaBundle:Cafes v, RussiaRussiaBundle:Stades s, RussiaRussiaBundle:Stades c
WHERE v.idville = c.idville AND s.idville = c.idville AND s.idville = :nom")
            ->setParameter('nom',$nom->getIdville());
        return $query->getResult();
    }

    public function stadehotel($nom)
    {
        $query=$this->getEntityManager()
            ->createQuery("select s from RussiaRussiaBundle:Hotels v, RussiaRussiaBundle:Stades s, RussiaRussiaBundle:Stades c
WHERE v.idville = c.idville AND s.idville = c.idville AND s.idville = :nom")
            ->setParameter('nom',$nom->getIdville());
        return $query->getResult();
    }

    public function staderesto($nom)
    {
        $query=$this->getEntityManager()
            ->createQuery("select s from RussiaRussiaBundle:Restos v, RussiaRussiaBundle:Stades s, RussiaRussiaBundle:Stades c
WHERE v.idville = c.idville AND s.idville = c.idville AND s.idville = :nom")
            ->setParameter('nom',$nom->getIdville());
        return $query->getResult();
    }

    public function cafecount()
    {
        $query=$this->getEntityManager()
            ->createQuery("select COUNT(v) from RussiaRussiaBundle:Stades v");
        return $query->getResult();
    }

}