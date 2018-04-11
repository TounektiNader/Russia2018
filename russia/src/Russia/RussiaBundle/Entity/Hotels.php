<?php

namespace Russia\RussiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Hotels
 *
 * @ORM\Table(name="hotels", indexes={@ORM\Index(name="idville", columns={"idville"})})
 * @ORM\Entity(repositoryClass="Russia\RussiaBundle\Repository\HotelRepository")
 */
class Hotels
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idhotel", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    public $idhotel;

    /**
     * @var string
     *
     * @ORM\Column(name="nomhotel", type="string", length=50, nullable=false)
     */
    public $nomhotel;

    /**
     * @var string
     *
     * @ORM\Column(name="detailshotel", type="string", length=200, nullable=false)
     */
    public $detailshotel;

    /**
     * @var string
     *
     * @ORM\Column(name="positionhotel", type="string", length=50, nullable=false)
     */
    public $positionhotel;

    /**
     * @var string
     * @Assert\File(mimeTypes={ "image/jpeg" })
     * @ORM\Column(name="photohotel", type="string", length=2000, nullable=false)
     */
    public $photohotel;

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
     * Set idhotel
     *
     * @param integer $idhotel
     *
     * @return Hotels
     */
    public function setIdhotel($idhotel)
    {
        $this->idhotel = $idhotel;

        return $this;
    }

    /**
     * Get idhotel
     *
     * @return integer
     */
    public function getIdhotel()
    {
        return $this->idhotel;
    }

    /**
     * Set nomhotel
     *
     * @param string $nomhotel
     *
     * @return Hotels
     */
    public function setNomhotel($nomhotel)
    {
        $this->nomhotel = $nomhotel;

        return $this;
    }

    /**
     * Get nomhotel
     *
     * @return string
     */
    public function getNomhotel()
    {
        return $this->nomhotel;
    }

    /**
     * Set detailshotel
     *
     * @param string $detailshotel
     *
     * @return Hotels
     */
    public function setDetailshotel($detailshotel)
    {
        $this->detailshotel = $detailshotel;

        return $this;
    }

    /**
     * Get detailshotel
     *
     * @return string
     */
    public function getDetailshotel()
    {
        return $this->detailshotel;
    }

    /**
     * Set positionhotel
     *
     * @param string $positionhotel
     *
     * @return Hotels
     */
    public function setPositionhotel($positionhotel)
    {
        $this->positionhotel = $positionhotel;

        return $this;
    }

    /**
     * Get positionhotel
     *
     * @return string
     */
    public function getPositionhotel()
    {
        return $this->positionhotel;
    }

    /**
     * Set photohotel
     *
     * @param string $photohotel
     *
     * @return Hotels
     */
    public function setPhotohotel($photohotel)
    {
        $this->photohotel = $photohotel;

        return $this;
    }

    /**
     * Get photohotel
     *
     * @return string
     */
    public function getPhotohotel()
    {
        return $this->photohotel;
    }

    /**
     * Set idville
     *
     * @param \Russia\RussiaBundle\Entity\Villes $idville
     *
     * @return Hotels
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
