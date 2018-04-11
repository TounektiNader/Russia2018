<?php

namespace Russia\RussiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cadeau
 *
 * @ORM\Table(name="cadeau")
 * @ORM\Entity
 */
class Cadeau
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idCadeau", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcadeau;

    /**
     * @var string
     *
     * @ORM\Column(name="Categorie", type="string", length=200, nullable=false)
     */
    private $categorie;

    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=500, nullable=false)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="jeton", type="integer", nullable=false)
     */
    private $jeton;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=500, nullable=false)
     */
    private $image;


}

