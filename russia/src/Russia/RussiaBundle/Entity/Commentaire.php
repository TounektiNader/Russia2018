<?php

namespace Russia\RussiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity
 */
class Commentaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="textcom", type="string", length=255)
     */
    private $textcom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datec", type="date")
     */
    private $datec;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set textcom
     *
     * @param string $textcom
     *
     * @return Commentaire
     */
    public function setTextcom($textcom)
    {
        $this->textcom = $textcom;

        return $this;
    }

    /**
     * Get textcom
     *
     * @return string
     */
    public function getTextcom()
    {
        return $this->textcom;
    }

    /**
     * Set datec
     *
     * @param \DateTime $datec
     *
     * @return Commentaire
     */
    public function setDatec($datec)
    {
        $this->datec = $datec;

        return $this;
    }

    /**
     * Get datec
     *
     * @return \DateTime
     */
    public function getDatec()
    {
        return $this->datec;
    }

    /**
     * @return mixed
     */
    public function getIdActualite()
    {
        return $this->idActualite;
    }

    /**
     * @param mixed $idActualite
     */
    public function setIdActualite($idActualite)
    {
        $this->idActualite = $idActualite;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param mixed $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Russia\RussiaBundle\Entity\Actualite")
     * @ORM\JoinColumn(name="idactualite", referencedColumnName="idactualite")
     */

    private $idActualite;


    /**
     *
     * @var \User
     * @ORM\ManyToOne(targetEntity="Russia\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="User_id", referencedColumnName="id")
     */
    private $idUser;
}

