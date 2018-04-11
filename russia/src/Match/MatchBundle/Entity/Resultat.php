<?php

namespace Match\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Resultat
 *
 * @ORM\Table(name="resultat", uniqueConstraints={@ORM\UniqueConstraint(name="idPartie", columns={"idPartie"})})
 * @ORM\Entity(repositoryClass="Match\MatchBundle\Repository\ResultatRepository")
 */
class Resultat
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idResultat", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idresultat;

    /**
     * @var integer
     *
     * @ORM\Column(name="butHome", type="integer", nullable=false)
     */
    private $buthome;

    /**
     * @var integer
     *
     * @ORM\Column(name="butAway", type="integer", nullable=false)
     */
    private $butaway;

    /**
     * @var \Partie
     *
     * @ORM\ManyToOne(targetEntity="Partie",cascade={"remove", "persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPartie", referencedColumnName="id")
     * })
     */
    private $idpartie;

    /**
     * @return int
     */
    public function getIdresultat()
    {
        return $this->idresultat;
    }

    /**
     * @param int $idresultat
     */
    public function setIdresultat($idresultat)
    {
        $this->idresultat = $idresultat;
    }

    /**
     * @return int
     */
    public function getButhome()
    {
        return $this->buthome;
    }

    /**
     * @param int $buthome
     */
    public function setButhome($buthome)
    {
        $this->buthome = $buthome;
    }

    /**
     * @return int
     */
    public function getButaway()
    {
        return $this->butaway;
    }

    /**
     * @param int $butaway
     */
    public function setButaway($butaway)
    {
        $this->butaway = $butaway;
    }

    /**
     * @return \Partie
     */
    public function getIdpartie()
    {
        return $this->idpartie;
    }

    /**
     * @param \Partie $idpartie
     */
    public function setIdpartie($idpartie)
    {
        $this->idpartie = $idpartie;
    }




}

