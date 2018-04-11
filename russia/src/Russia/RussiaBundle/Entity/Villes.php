<?php

namespace Russia\RussiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Villes
 *
 * @ORM\Table(name="villes")
 * @ORM\Entity(repositoryClass="Russia\RussiaBundle\Repository\VilleRepository")
 */
class Villes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idville", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    public $idville;

    /**
     * @var string
     *
     * @ORM\Column(name="nomville", type="text", length=65535, nullable=false)
     */
    public $nomville;

    /**
     * @var string
     *
     * @ORM\Column(name="fondationville", type="string", length=4, nullable=false)
     */
    public $fondationville;

    /**
     * @var string
     *
     * @ORM\Column(name="populationville", type="string", length=20, nullable=false)
     */
    public $populationville;

    /**
     * @var string
     *
     * @ORM\Column(name="timezone", type="string", length=20, nullable=false)
     */
    public $timezone;

    /**
     * @var string
     * @Assert\File(mimeTypes={ "image/jpeg" })
     * @ORM\Column(name="photoville", type="string", length=100, nullable=false)
     */
    public $photoville;

    /**
     * @var string
     *
     * @ORM\Column(name="equipelocale", type="string", length=50, nullable=false)
     */
    public $equipelocale;

    /**
     * @var string
     * @Assert\File(mimeTypes={ "image/jpeg" })
     * @ORM\Column(name="logoville", type="string", length=100, nullable=false)
     */
    public $logoville;

    /**
     * @var string
     * @Assert\File(mimeTypes={ "image/jpeg" })
     * @ORM\Column(name="logoequipe", type="string", length=100, nullable=false)
     */
    public $logoequipe;

    /**
     * @var string
     *
     * @ORM\Column(name="coordonnees", type="string", length=50, nullable=false)
     */
    public $coordonnees;



    /**
     * Get idville
     *
     * @return integer
     */
    public function getIdville()
    {
        return $this->idville;
    }

    /**
     * Set nomville
     *
     * @param string $nomville
     *
     * @return Villes
     */
    public function setNomville($nomville)
    {
        $this->nomville = $nomville;

        return $this;
    }

    /**
     * Get nomville
     *
     * @return string
     */
    public function getNomville()
    {
        return $this->nomville;
    }

    /**
     * Set fondationville
     *
     * @param string $fondationville
     *
     * @return Villes
     */
    public function setFondationville($fondationville)
    {
        $this->fondationville = $fondationville;

        return $this;
    }

    /**
     * Get fondationville
     *
     * @return string
     */
    public function getFondationville()
    {
        return $this->fondationville;
    }

    /**
     * Set populationville
     *
     * @param string $populationville
     *
     * @return Villes
     */
    public function setPopulationville($populationville)
    {
        $this->populationville = $populationville;

        return $this;
    }

    /**
     * Get populationville
     *
     * @return string
     */
    public function getPopulationville()
    {
        return $this->populationville;
    }

    /**
     * Set timezone
     *
     * @param string $timezone
     *
     * @return Villes
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * Get timezone
     *
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * Set photoville
     *
     * @param string $photoville
     *
     * @return Villes
     */
    public function setPhotoville($photoville)
    {
        $this->photoville = $photoville;

        return $this;
    }

    /**
     * Get photoville
     *
     * @return string
     */
    public function getPhotoville()
    {
        return $this->photoville;
    }

    /**
     * Set equipelocale
     *
     * @param string $equipelocale
     *
     * @return Villes
     */
    public function setEquipelocale($equipelocale)
    {
        $this->equipelocale = $equipelocale;

        return $this;
    }

    /**
     * Get equipelocale
     *
     * @return string
     */
    public function getEquipelocale()
    {
        return $this->equipelocale;
    }

    /**
     * Set logoville
     *
     * @param string $logoville
     *
     * @return Villes
     */
    public function setLogoville($logoville)
    {
        $this->logoville = $logoville;

        return $this;
    }

    /**
     * Get logoville
     *
     * @return string
     */
    public function getLogoville()
    {
        return $this->logoville;
    }

    /**
     * Set logoequipe
     *
     * @param string $logoequipe
     *
     * @return Villes
     */
    public function setLogoequipe($logoequipe)
    {
        $this->logoequipe = $logoequipe;

        return $this;
    }

    /**
     * Get logoequipe
     *
     * @return string
     */
    public function getLogoequipe()
    {
        return $this->logoequipe;
    }

    /**
     * Set coordonnees
     *
     * @param string $coordonnees
     *
     * @return Villes
     */
    public function setCoordonnees($coordonnees)
    {
        $this->coordonnees = $coordonnees;

        return $this;
    }

    /**
     * Get coordonnees
     *
     * @return string
     */
    public function getCoordonnees()
    {
        return $this->coordonnees;
    }
}
