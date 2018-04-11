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

class CafeRepository extends EntityRepository
{
    public function findSerieDQL($nom)
    {
        $query=$this->getEntityManager()
            ->createQuery("select v from RussiaRussiaBundle:Cafes v
WHERE v.nomcafe LIKE :nom
ORDER BY v.nomcafe ASC")
            ->setParameter('nom','%'.$nom.'%');
        return $query->getResult();
    }

    public function cafeville($nom)
    {
        $query=$this->getEntityManager()
            ->createQuery("select v from RussiaRussiaBundle:Cafes v, RussiaRussiaBundle:Villes c
WHERE v.idville = c.idville AND c.idville = :nom
ORDER BY v.nomcafe ASC")
            ->setParameter('nom',$nom->getIdville());
        return $query->getResult();
    }



}