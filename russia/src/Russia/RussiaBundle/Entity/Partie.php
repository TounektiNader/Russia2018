<?php

namespace Russia\RussiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Partie
 *
 * @ORM\Table(name="partie", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})}, indexes={@ORM\Index(name="c7", columns={"idStade"}), @ORM\Index(name="c5", columns={"home"}), @ORM\Index(name="c6", columns={"away"})})
 * @ORM\Entity
 */
class Partie
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
     * @ORM\Column(name="etiquette", type="string", length=200, nullable=true)
     */
    private $etiquette;

    /**
     * @var \Equipe
     *
     * @ORM\Id
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
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="away", referencedColumnName="idEquipe")
     * })
     */
    private $away;




}

