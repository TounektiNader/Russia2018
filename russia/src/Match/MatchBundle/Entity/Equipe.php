<?php

namespace Match\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipe
 *
 * @ORM\Table(name="equipe")
 * @ORM\Entity(repositoryClass="Match\MatchBundle\Repository\EquipeRepository")
 */
class Equipe
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idEquipe", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idequipe;

    /**
     * @var string
     *
     * @ORM\Column(name="NomEquipe", type="string", length=200, nullable=false)
     */
    private $nomequipe;

    /**
     * @var string
     *
     * @ORM\Column(name="Entraineur", type="string", length=200, nullable=false)
     */
    private $entraineur;

    /**
     * @var string
     *
     * @ORM\Column(name="Continent", type="string", length=200, nullable=false)
     */
    private $continent;

    /**
     * @var string
     *
     * @ORM\Column(name="Drapeau", type="string", length=200, nullable=false)
     */
    private $drapeau;

    /**
     * @var string
     *
     * @ORM\Column(name="Groupe", type="string", length=20, nullable=false)
     */
    private $groupe;

    /**
     * @var integer
     *
     * @ORM\Column(name="ButMarque", type="integer", nullable=false)
     */
    private $butmarque;

    /**
     * @var integer
     *
     * @ORM\Column(name="butEncaisse", type="integer", nullable=false)
     */
    private $butencaisse;

    /**
     * @var integer
     *
     * @ORM\Column(name="MatchJouee", type="integer", nullable=false)
     */
    private $matchjouee;

    /**
     * @var integer
     *
     * @ORM\Column(name="MatchNull", type="integer", nullable=false)
     */
    private $matchnull;

    /**
     * @var integer
     *
     * @ORM\Column(name="MatchGagne", type="integer", nullable=false)
     */
    private $matchgagne;

    /**
     * @var integer
     *
     * @ORM\Column(name="MatchPerdu", type="integer", nullable=false)
     */
    private $matchperdu;

    /**
     * @var integer
     *
     * @ORM\Column(name="NombrePoints", type="integer", nullable=false)
     */
    private $nombrepoints;

    /**
     * @return int
     */
    public function getIdequipe()
    {
        return $this->idequipe;
    }

    /**
     * @param int $idequipe
     */
    public function setIdequipe($idequipe)
    {
        $this->idequipe = $idequipe;
    }

    /**
     * @return string
     */
    public function getNomequipe()
    {
        return $this->nomequipe;
    }

    /**
     * @param string $nomequipe
     */
    public function setNomequipe($nomequipe)
    {
        $this->nomequipe = $nomequipe;
    }

    /**
     * @return string
     */
    public function getEntraineur()
    {
        return $this->entraineur;
    }

    /**
     * @param string $entraineur
     */
    public function setEntraineur($entraineur)
    {
        $this->entraineur = $entraineur;
    }

    /**
     * @return string
     */
    public function getContinent()
    {
        return $this->continent;
    }

    /**
     * @param string $continent
     */
    public function setContinent($continent)
    {
        $this->continent = $continent;
    }

    /**
     * @return string
     */
    public function getDrapeau()
    {
        return $this->drapeau;
    }

    /**
     * @param string $drapeau
     */
    public function setDrapeau($drapeau)
    {
        $this->drapeau = $drapeau;
    }

    /**
     * @return string
     */
    public function getGroupe()
    {
        return $this->groupe;
    }

    /**
     * @param string $groupe
     */
    public function setGroupe($groupe)
    {
        $this->groupe = $groupe;
    }

    /**
     * @return int
     */
    public function getButmarque()
    {
        return $this->butmarque;
    }

    /**
     * @param int $butmarque
     */
    public function setButmarque($butmarque)
    {
        $this->butmarque = $butmarque;
    }

    /**
     * @return int
     */
    public function getButencaisse()
    {
        return $this->butencaisse;
    }

    /**
     * @param int $butencaisse
     */
    public function setButencaisse($butencaisse)
    {
        $this->butencaisse = $butencaisse;
    }

    /**
     * @return int
     */
    public function getMatchjouee()
    {
        return $this->matchjouee;
    }

    /**
     * @param int $matchjouee
     */
    public function setMatchjouee($matchjouee)
    {
        $this->matchjouee = $matchjouee;
    }

    /**
     * @return int
     */
    public function getMatchnull()
    {
        return $this->matchnull;
    }

    /**
     * @param int $matchnull
     */
    public function setMatchnull($matchnull)
    {
        $this->matchnull = $matchnull;
    }

    /**
     * @return int
     */
    public function getMatchgagne()
    {
        return $this->matchgagne;
    }

    /**
     * @param int $matchgagne
     */
    public function setMatchgagne($matchgagne)
    {
        $this->matchgagne = $matchgagne;
    }

    /**
     * @return int
     */
    public function getMatchperdu()
    {
        return $this->matchperdu;
    }

    /**
     * @param int $matchperdu
     */
    public function setMatchperdu($matchperdu)
    {
        $this->matchperdu = $matchperdu;
    }

    /**
     * @return int
     */
    public function getNombrepoints()
    {
        return $this->nombrepoints;
    }

    /**
     * @param int $nombrepoints
     */
    public function setNombrepoints($nombrepoints)
    {
        $this->nombrepoints = $nombrepoints;
    }

    public function __toString()
    {
       return $this->getNomequipe();
    }


}

