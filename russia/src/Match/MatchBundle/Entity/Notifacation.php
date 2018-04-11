<?php

namespace Match\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notifacation
 *
 * @ORM\Table(name="notifacation", indexes={@ORM\Index(name="c90", columns={"idbet"}), @ORM\Index(name="c91", columns={"username"})})
 * @ORM\Entity(repositoryClass="Match\MatchBundle\Repository\NotificationRepository")
 */
class Notifacation
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
     * @var integer
     *
     * @ORM\Column(name="etat", type="integer", nullable=false)
     */
    private $etat;

    /**
     * @var \Bet
     *
     *
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Bet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idbet", referencedColumnName="idBet")
     * })
     */
    private $idbet;

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
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

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
     * @return int
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param int $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return \Bet
     */
    public function getIdbet()
    {
        return $this->idbet;
    }

    /**
     * @param \Bet $idbet
     */
    public function setIdbet($idbet)
    {
        $this->idbet = $idbet;
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
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }


}

