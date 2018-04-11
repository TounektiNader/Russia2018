<?php

namespace Match\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bet
 *
 * @ORM\Table(name="bet", indexes={@ORM\Index(name="c11", columns={"idPartie"}), @ORM\Index(name="c10", columns={"username"})})
 * @ORM\Entity(repositoryClass="Match\MatchBundle\Repository\BetRepository")
 */
class Bet
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idBet", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idbet;

    /**
     * @var integer
     *
     * @ORM\Column(name="valeur", type="integer", nullable=true)
     */
    private $valeur;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=100, nullable=true)
     */
    private $etat;

    /**
     * @var \User
     *
     *
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="username", referencedColumnName="id")
     * })
     */
    private $username;

    /**
     * @var \Partie
     *
     *
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Partie",cascade={"remove", "persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPartie", referencedColumnName="id")
     * })
     */
    private $idpartie;

    /**
     * @return int
     */
    public function getIdbet()
    {
        return $this->idbet;
    }

    /**
     * @param int $idbet
     */
    public function setIdbet($idbet)
    {
        $this->idbet = $idbet;
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

    /**
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return \User
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param \User $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
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

