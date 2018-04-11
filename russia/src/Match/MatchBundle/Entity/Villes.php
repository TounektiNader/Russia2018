<?php

namespace Match\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Villes
 *
 * @ORM\Table(name="villes")
 * @ORM\Entity
 */
class Villes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idville", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idville;

    /**
     * @var string
     *
     * @ORM\Column(name="nomville", type="text", length=65535, nullable=false)
     */
    private $nomville;

    /**
     * @var string
     *
     * @ORM\Column(name="fondationville", type="string", length=4, nullable=false)
     */
    private $fondationville;

    /**
     * @var string
     *
     * @ORM\Column(name="populationville", type="string", length=20, nullable=false)
     */
    private $populationville;

    /**
     * @var string
     *
     * @ORM\Column(name="timezone", type="string", length=20, nullable=false)
     */
    private $timezone;

    /**
     * @var string
     *
     * @ORM\Column(name="photoville", type="string", length=100, nullable=false)
     */
    private $photoville;

    /**
     * @var string
     *
     * @ORM\Column(name="equipelocale", type="string", length=50, nullable=false)
     */
    private $equipelocale;

    /**
     * @var string
     *
     * @ORM\Column(name="logoville", type="string", length=100, nullable=false)
     */
    private $logoville;

    /**
     * @var string
     *
     * @ORM\Column(name="logoequipe", type="string", length=100, nullable=false)
     */
    private $logoequipe;

    /**
     * @var string
     *
     * @ORM\Column(name="coordonnees", type="string", length=50, nullable=false)
     */
    private $coordonnees;


}

