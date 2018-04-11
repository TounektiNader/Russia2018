<?php

namespace Match\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Partie
 *
 * @ORM\Table(name="partie", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})},indexes={@ORM\Index(name="c7", columns={"idStade"}), @ORM\Index(name="c5", columns={"home"}), @ORM\Index(name="c6", columns={"away"})})
 * @ORM\Entity(repositoryClass="Match\MatchBundle\Repository\PartieRepository")
  */
class Partie
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datePartie", type="date", nullable=true)
     */
    private $datepartie;

    /**
     * @var string
     *
     * @ORM\Column(name="heurePartie", type="string", length=100, nullable=true)
     */
    private $heurepartie;

    /**
     * @var string
     *
     * @ORM\Column(name="groupe", type="string", length=10, nullable=true)
     */
    private $groupe;

    /**
     * @var string
     *
     * @ORM\Column(name="tour", type="string", length=50, nullable=true)
     */
    private $tour;

    /**
     * @var string
     *
     * @ORM\Column(name="etatMatch", type="string", length=50, nullable=true)
     */
    private $etatmatch;

    /**
     * @var string
     *
     * @ORM\Column(name="etiquette", type="string", length=200, nullable=false)
     */
    private $etiquette;

    /**
     * @var \Equipe
     *
     *
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="home", referencedColumnName="idEquipe")
     * })
     */
    private $home;

    /**
     * @var \Equipe
     *
     *
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="away", referencedColumnName="idEquipe")
     * })
     */
    private $away;

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
     * @return \DateTime
     */
    public function getDatepartie()
    {
        return $this->datepartie;
    }

    /**
     * @param \DateTime $datepartie
     */
    public function setDatepartie($datepartie)
    {
        $this->datepartie = $datepartie;
    }

    /**
     * @return string
     */
    public function getHeurepartie()
    {
        return $this->heurepartie;
    }

    /**
     * @param string $heurepartie
     */
    public function setHeurepartie($heurepartie)
    {
        $this->heurepartie = $heurepartie;
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
     * @return string
     */
    public function getTour()
    {
        return $this->tour;
    }

    /**
     * @param string $tour
     */
    public function setTour($tour)
    {
        $this->tour = $tour;
    }

    /**
     * @return string
     */
    public function getEtatmatch()
    {
        return $this->etatmatch;
    }

    /**
     * @param string $etatmatch
     */
    public function setEtatmatch($etatmatch)
    {
        $this->etatmatch = $etatmatch;
    }

    /**
     * @return string
     */
    public function getEtiquette()
    {
        return $this->etiquette;
    }

    /**
     * @param string $etiquette
     */
    public function setEtiquette($etiquette)
    {
        $this->etiquette = $etiquette;
    }

    /**
     * @return \Equipe
     */
    public function getHome()
    {
        return $this->home;
    }

    /**
     * @param \Equipe $home
     */
    public function setHome($home)
    {
        $this->home = $home;
    }

    /**
     * @return \Equipe
     */
    public function getAway()
    {
        return $this->away;
    }

    /**
     * @param \Equipe $away
     */
    public function setAway($away)
    {
        $this->away = $away;
    }

    /**
     * @var \Stades
     *
     *
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Stades")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idStade", referencedColumnName="idstade")
     * })
     */
    private $idstade;

    /**
     * @return \Stades
     */
    public function getIdstade()
    {
        return $this->idstade;
    }

    /**
     * @param \Stades $idstade
     */
    public function setIdstade($idstade)
    {
        $this->idstade = $idstade;
    }

    public function __construct()
    {
        $this->datepartie = new \DateTime();
    }


}

