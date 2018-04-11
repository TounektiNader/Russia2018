<?php
/**
 * Created by PhpStorm.
 * User: Nader
 * Date: 20/03/2018
 * Time: 21:15
 */

namespace Match\MatchBundle\Repository;


class EquipeRepository extends \Doctrine\ORM\EntityRepository
{
    function findEquipe($p)
    {
        $query=$this->getEntityManager()->createQuery(
            "select m from MatchMatchBundle:Equipe m WHERE m.groupe LIKE :p ORDER By m.nombrepoints DESC" )->setParameter('p','%'.$p.'%');
        return $query->getResult();

    }

    function findPartie($p)
    {
        $query=$this->getEntityManager()->createQuery(
            "select m from MatchMatchBundle:Partie m WHERE m.groupe LIKE :p " )->setParameter('p','%'.$p.'%');
        return $query->getResult();

    }

    function findEquipeRecherche($p)
    {
        $query=$this->getEntityManager()->createQuery(
            "select m from MatchMatchBundle:Equipe m WHERE m.nomequipe LIKE :p")->setParameter('p','%'.$p.'%');
        return $query->getResult();

    }




    public function filtreEquipeParNom()
{
    $querry = $this->getEntityManager()->createQuery("select m from MatchMatchBundle:Equipe m  ORDER By m.nomequipe ");
    return $querry->getResult();
}
    public function filtreEquipeParContenent()
    {
        $querry = $this->getEntityManager()->createQuery("select m from MatchMatchBundle:Equipe m  ORDER By m.continent ");
        return $querry->getResult();
    }
    public function filtreEquipeParGroupe()
    {
        $querry = $this->getEntityManager()->createQuery("select m from MatchMatchBundle:Equipe m  ORDER By m.groupe ");
        return $querry->getResult();
    }
    function continent()
    {
        $query=$this->getEntityManager()->createQuery(
            "select m.continent from MatchMatchBundle:Equipe m GROUP  by m.continent " );
        return $query->getResult();

    }

}