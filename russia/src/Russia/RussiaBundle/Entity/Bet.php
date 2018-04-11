<?php

namespace Russia\RussiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Bet
 *
 * @ORM\Table(name="bet", indexes={@ORM\Index(name="c11", columns={"idPartie"}), @ORM\Index(name="c10", columns={"username"})})
 * @ORM\Entity
 */
class Bet
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idBet", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
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
     * @ORM\Id
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
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Partie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPartie", referencedColumnName="id")
     * })
     */
    private $idpartie;


}

