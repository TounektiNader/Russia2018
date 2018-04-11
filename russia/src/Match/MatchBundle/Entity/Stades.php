<?php

namespace Match\MatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stades
 *
 * @ORM\Table(name="stades", indexes={@ORM\Index(name="idville", columns={"idville"})})
 * @ORM\Entity
 */
class Stades
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idstade", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idstade;

    /**
     * @var string
     *
     * @ORM\Column(name="nomstade", type="string", length=50, nullable=false)
     */
    private $nomstade;

    /**
     * @var string
     *
     * @ORM\Column(name="fondationstade", type="string", length=4, nullable=false)
     */
    private $fondationstade;

    /**
     * @var string
     *
     * @ORM\Column(name="capacitestade", type="string", length=50, nullable=false)
     */
    private $capacitestade;

    /**
     * @var string
     *
     * @ORM\Column(name="photostade", type="string", length=100, nullable=false)
     */
    private $photostade;

    /**
     * @var string
     *
     * @ORM\Column(name="equipestade", type="string", length=50, nullable=false)
     */
    private $equipestade;

    /**
     * @var string
     *
     * @ORM\Column(name="positionstade", type="string", length=50, nullable=false)
     */
    private $positionstade;

    /**
     * @return int
     */
    public function getIdstade()
    {
        return $this->idstade;
    }

    /**
     * @param int $idstade
     */
    public function setIdstade($idstade)
    {
        $this->idstade = $idstade;
    }

    /**
     * @return string
     */
    public function getNomstade()
    {
        return $this->nomstade;
    }

    /**
     * @param string $nomstade
     */
    public function setNomstade($nomstade)
    {
        $this->nomstade = $nomstade;
    }

    /**
     * @return string
     */
    public function getFondationstade()
    {
        return $this->fondationstade;
    }

    /**
     * @param string $fondationstade
     */
    public function setFondationstade($fondationstade)
    {
        $this->fondationstade = $fondationstade;
    }

    /**
     * @return string
     */
    public function getCapacitestade()
    {
        return $this->capacitestade;
    }

    /**
     * @param string $capacitestade
     */
    public function setCapacitestade($capacitestade)
    {
        $this->capacitestade = $capacitestade;
    }

    /**
     * @return string
     */
    public function getPhotostade()
    {
        return $this->photostade;
    }

    /**
     * @param string $photostade
     */
    public function setPhotostade($photostade)
    {
        $this->photostade = $photostade;
    }

    /**
     * @return string
     */
    public function getEquipestade()
    {
        return $this->equipestade;
    }

    /**
     * @param string $equipestade
     */
    public function setEquipestade($equipestade)
    {
        $this->equipestade = $equipestade;
    }

    /**
     * @return string
     */
    public function getPositionstade()
    {
        return $this->positionstade;
    }

    /**
     * @param string $positionstade
     */
    public function setPositionstade($positionstade)
    {
        $this->positionstade = $positionstade;
    }

    public function __toString()
    {


        return $this->getNomstade();

    }


}

