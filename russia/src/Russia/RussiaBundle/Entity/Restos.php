<?php

namespace Russia\RussiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Restos
 *
 * @ORM\Table(name="restos", indexes={@ORM\Index(name="idville", columns={"idville"})})
 * @ORM\Entity(repositoryClass="Russia\RussiaBundle\Repository\RestoRepository")
 */
class Restos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idresto", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    public $idresto;

    /**
     * @var string
     *
     * @ORM\Column(name="nomresto", type="string", length=50, nullable=false)
     */
    public $nomresto;

    /**
     * @var string
     *
     * @ORM\Column(name="detailsresto", type="string", length=200, nullable=false)
     */
    public $detailsresto;

    /**
     * @var string
     *
     * @ORM\Column(name="positionresto", type="string", length=50, nullable=false)
     */
    public $positionresto;

    /**
     * @var string
     * @Assert\File(mimeTypes={ "image/jpeg" })
     * @ORM\Column(name="photoresto", type="string", length=50, nullable=false)
     */
    public $photoresto;

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
     * Set idresto
     *
     * @param integer $idresto
     *
     * @return Restos
     */
    public function setIdresto($idresto)
    {
        $this->idresto = $idresto;

        return $this;
    }

    /**
     * Get idresto
     *
     * @return integer
     */
    public function getIdresto()
    {
        return $this->idresto;
    }

    /**
     * Set nomresto
     *
     * @param string $nomresto
     *
     * @return Restos
     */
    public function setNomresto($nomresto)
    {
        $this->nomresto = $nomresto;

        return $this;
    }

    /**
     * Get nomresto
     *
     * @return string
     */
    public function getNomresto()
    {
        return $this->nomresto;
    }

    /**
     * Set detailsresto
     *
     * @param string $detailsresto
     *
     * @return Restos
     */
    public function setDetailsresto($detailsresto)
    {
        $this->detailsresto = $detailsresto;

        return $this;
    }

    /**
     * Get detailsresto
     *
     * @return string
     */
    public function getDetailsresto()
    {
        return $this->detailsresto;
    }

    /**
     * Set positionresto
     *
     * @param string $positionresto
     *
     * @return Restos
     */
    public function setPositionresto($positionresto)
    {
        $this->positionresto = $positionresto;

        return $this;
    }

    /**
     * Get positionresto
     *
     * @return string
     */
    public function getPositionresto()
    {
        return $this->positionresto;
    }

    /**
     * Set photoresto
     *
     * @param string $photoresto
     *
     * @return Restos
     */
    public function setPhotoresto($photoresto)
    {
        $this->photoresto = $photoresto;

        return $this;
    }

    /**
     * Get photoresto
     *
     * @return string
     */
    public function getPhotoresto()
    {
        return $this->photoresto;
    }

    /**
     * Set idville
     *
     * @param \Russia\RussiaBundle\Entity\Villes $idville
     *
     * @return Restos
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
