<?php

namespace Russia\RussiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Resultat
 *
 * @ORM\Table(name="resultat", uniqueConstraints={@ORM\UniqueConstraint(name="idPartie", columns={"idPartie"})})
 * @ORM\Entity
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
     * @ORM\ManyToOne(targetEntity="Partie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idPartie", referencedColumnName="id")
     * })
     */
    private $idpartie;


}

