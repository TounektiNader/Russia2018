<?php

namespace Russia\RussiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipe
 *
 * @ORM\Table(name="equipe")
 * @ORM\Entity
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


}

