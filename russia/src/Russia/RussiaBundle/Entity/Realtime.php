<?php

namespace Russia\RussiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Realtime
 *
 * @ORM\Table(name="realtime", indexes={@ORM\Index(name="c41", columns={"idPartie"}), @ORM\Index(name="c42", columns={"idJoueur"})})
 * @ORM\Entity
 */
class Realtime
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idRealTime", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idrealtime;

    /**
     * @var string
     *
     * @ORM\Column(name="actions", type="string", length=1000, nullable=true)
     */
    private $actions;

    /**
     * @var integer
     *
     * @ORM\Column(name="idJoueur", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idjoueur;

    /**
     * @var integer
     *
     * @ORM\Column(name="temps", type="integer", nullable=true)
     */
    private $temps;

    /**
     * @var integer
     *
     * @ORM\Column(name="idPartie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idpartie;


}

