<?php

namespace Russia\RussiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Stades
 *
 * @ORM\Table(name="stades", indexes={@ORM\Index(name="idville", columns={"idville"})})
 * @ORM\Entity(repositoryClass="Russia\RussiaBundle\Repository\StadeRepository")
 */
class Stades
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idstade", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    public $idstade;

    /**
     * @var string
     *
     * @ORM\Column(name="nomstade", type="string", length=50, nullable=false)
     */
    public $nomstade;

    /**
     * @var string
     *
     * @ORM\Column(name="fondationstade", type="string", length=4, nullable=false)
     */
    public $fondationstade;

    /**
     * @var string
     *
     * @ORM\Column(name="capacitestade", type="string", length=50, nullable=false)
     */
    public $capacitestade;

    /**
     * @var string
     * @Assert\File(mimeTypes={ "image/jpeg" })
     * @ORM\Column(name="photostade", type="string", length=100, nullable=false)
     */
    public $photostade;

    /**
     * @var string
     *
     * @ORM\Column(name="equipestade", type="string", length=50, nullable=false)
     */
    public $equipestade;

    /**
     * @var string
     *
     * @ORM\Column(name="positionstade", type="string", length=50, nullable=false)
     */
    public $positionstade;

    /**
     * @var \Villes
     *
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Villes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idville", referencedColumnName="idville")
     * })
     */
    public $idville;



    /**
     * Set idstade
     *
     * @param integer $idstade
     *
     * @return Stades
     */
    public function setIdstade($idstade)
    {
        $this->idstade = $idstade;

        return $this;
    }

    /**
     * Get idstade
     *
     * @return integer
     */
    public function getIdstade()
    {
        return $this->idstade;
    }

    /**
     * Set nomstade
     *
     * @param string $nomstade
     *
     * @return Stades
     */
    public function setNomstade($nomstade)
    {
        $this->nomstade = $nomstade;

        return $this;
    }

    /**
     * Get nomstade
     *
     * @return string
     */
    public function getNomstade()
    {
        return $this->nomstade;
    }

    /**
     * Set fondationstade
     *
     * @param string $fondationstade
     *
     * @return Stades
     */
    public function setFondationstade($fondationstade)
    {
        $this->fondationstade = $fondationstade;

        return $this;
    }

    /**
     * Get fondationstade
     *
     * @return string
     */
    public function getFondationstade()
    {
        return $this->fondationstade;
    }

    /**
     * Set capacitestade
     *
     * @param string $capacitestade
     *
     * @return Stades
     */
    public function setCapacitestade($capacitestade)
    {
        $this->capacitestade = $capacitestade;

        return $this;
    }

    /**
     * Get capacitestade
     *
     * @return string
     */
    public function getCapacitestade()
    {
        return $this->capacitestade;
    }

    /**
     * Set photostade
     *
     * @param string $photostade
     *
     * @return Stades
     */
    public function setPhotostade($photostade)
    {
        $this->photostade = $photostade;

        return $this;
    }

    /**
     * Get photostade
     *
     * @return string
     */
    public function getPhotostade()
    {
        return $this->photostade;
    }

    /**
     * Set equipestade
     *
     * @param string $equipestade
     *
     * @return Stades
     */
    public function setEquipestade($equipestade)
    {
        $this->equipestade = $equipestade;

        return $this;
    }

    /**
     * Get equipestade
     *
     * @return string
     */
    public function getEquipestade()
    {
        return $this->equipestade;
    }

    /**
     * Set positionstade
     *
     * @param string $positionstade
     *
     * @return Stades
     */
    public function setPositionstade($positionstade)
    {
        $this->positionstade = $positionstade;

        return $this;
    }

    /**
     * Get positionstade
     *
     * @return string
     */
    public function getPositionstade()
    {
        return $this->positionstade;
    }

    /**
     * Set idville
     *
     * @param \Russia\RussiaBundle\Entity\Villes $idville
     *
     * @return Stades
     */
    public function setIdville(\Russia\RussiaBundle\Entity\Villes $idville = null)
    {
        $this->idville = $idville;

        return $this;
    }

    /**
     * Get idville
     *
     * @return \Russia\RussiaBundle\Entity\Villes
     */
    public function getIdville()
    {
        return $this->idville;
    }
}
