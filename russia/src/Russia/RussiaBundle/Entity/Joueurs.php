<?php

namespace Russia\RussiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Joueurs
 *
 * @ORM\Table(name="joueurs", indexes={@ORM\Index(name="idEquipe", columns={"idEquipe"})})
 * @ORM\Entity
 */
class Joueurs
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Idjoueur", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idjoueur;

    /**
     * @var string
     *
     * @ORM\Column(name="nomJoueur", type="string", length=200, nullable=false)
     */
    private $nomjoueur;

    /**
     * @var string
     *
     * @ORM\Column(name="prenomJoueur", type="string", length=200, nullable=false)
     */
    private $prenomjoueur;

    /**
     * @var string
     *
     * @ORM\Column(name="postion", type="string", length=200, nullable=false)
     */
    private $postion;

    /**
     * @var \Equipe
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEquipe", referencedColumnName="idEquipe")
     * })
     */
    private $idequipe;


}

