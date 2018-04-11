<?php

namespace Russia\RussiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recompense
 *
 * @ORM\Table(name="recompense", indexes={@ORM\Index(name="c51", columns={"idCadeau"}), @ORM\Index(name="c52", columns={"username"})})
 * @ORM\Entity
 */
class Recompense
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idRecompense", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idrecompense;

    /**
     * @var \Cadeau
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Cadeau")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCadeau", referencedColumnName="idCadeau")
     * })
     */
    private $idcadeau;

    /**
     * @var \User
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="username", referencedColumnName="username_canonical")
     * })
     */
    private $username;


}

