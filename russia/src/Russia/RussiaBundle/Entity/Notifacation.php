<?php

namespace Russia\RussiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notifacation
 *
 * @ORM\Table(name="notifacation", indexes={@ORM\Index(name="c90", columns={"idbet"}), @ORM\Index(name="c91", columns={"username"})})
 * @ORM\Entity
 */
class Notifacation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
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
     * @ORM\Id
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
     * @ORM\Id
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

}

