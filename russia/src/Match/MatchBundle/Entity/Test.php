<?php
/**
 * Created by PhpStorm.
 * User: Nader
 * Date: 23/03/2018
 * Time: 08:34
 */

namespace Match\MatchBundle\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * Bet
 *
 * @ORM\Table(name="test")
 * @ORM\Entity
 */
class Test
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="valeur", type="integer")
     */
    private $valeur;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }



    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return int
     */
    public function getValeur()
    {
        return $this->valeur;
    }

    /**
     * @param int $valeur
     */
    public function setValeur($valeur)
    {
        $this->valeur = $valeur;
    }


}

