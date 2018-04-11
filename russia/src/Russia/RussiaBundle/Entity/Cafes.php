<?php

namespace Russia\RussiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Cafes
 *
 * @ORM\Table(name="cafes", indexes={@ORM\Index(name="idville", columns={"idville"})})
 * @ORM\Entity(repositoryClass="Russia\RussiaBundle\Repository\CafeRepository")
 */
class Cafes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idcafe", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    public $idcafe;

    /**
     * @var string
     * @Assert\Length(min=2)
     * @ORM\Column(name="nomcafe", type="string", length=50, nullable=false)
     */
    public $nomcafe;

    /**
     * @var string
     * @Assert\Length(min=10)
     * @ORM\Column(name="detailscafe", type="string", length=200, nullable=false)
     */
    public $detailscafe;

    /**
     * @var string
     * @Assert\Length(min=10)
     * @ORM\Column(name="positioncafe", type="string", length=50, nullable=false)
     */
    public $positioncafe;

    /**
     * @var string
     * @Assert\File(mimeTypes={ "image/jpeg" })
     * @ORM\Column(name="photocafe", type="string", length=50, nullable=false)
     */
    public $photocafe;

    /**
     * @var \Villes
     *
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\ManyToOne(targetEntity="Villes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idville", referencedColumnName="idville")
     * })
     */
    public $idville;



    /**
     * Set idcafe
     *
     * @param integer $idcafe
     *
     * @return Cafes
     */
    public function setIdcafe($idcafe)
    {
        $this->idcafe = $idcafe;

        return $this;
    }

    /**
     * Get idcafe
     *
     * @return integer
     */
    public function getIdcafe()
    {
        return $this->idcafe;
    }

    /**
     * Set nomcafe
     *
     * @param string $nomcafe
     *
     * @return Cafes
     */
    public function setNomcafe($nomcafe)
    {
        $this->nomcafe = $nomcafe;

        return $this;
    }

    /**
     * Get nomcafe
     *
     * @return string
     */
    public function getNomcafe()
    {
        return $this->nomcafe;
    }

    /**
     * Set detailscafe
     *
     * @param string $detailscafe
     *
     * @return Cafes
     */
    public function setDetailscafe($detailscafe)
    {
        $this->detailscafe = $detailscafe;

        return $this;
    }

    /**
     * Get detailscafe
     *
     * @return string
     */
    public function getDetailscafe()
    {
        return $this->detailscafe;
    }

    /**
     * Set positioncafe
     *
     * @param string $positioncafe
     *
     * @return Cafes
     */
    public function setPositioncafe($positioncafe)
    {
        $this->positioncafe = $positioncafe;

        return $this;
    }

    /**
     * Get positioncafe
     *
     * @return string
     */
    public function getPositioncafe()
    {
        return $this->positioncafe;
    }

    /**
     * Set photocafe
     *
     * @param string $photocafe
     *
     * @return Cafes
     */
    public function setPhotocafe($photocafe)
    {
        $this->photocafe = $photocafe;

        return $this;
    }

    /**
     * Get photocafe
     *
     * @return string
     */
    public function getPhotocafe()
    {
        return $this->photocafe;
    }

    /**
     * Set idville
     *
     * @param Villes $idville
     *
     * @return Cafes
     */
    public function setIdville(Villes $idville = null)
    {
        $this->idville = $idville;

        return $this;
    }

    /**
     * Get idville
     *
     * @return Villes
     */
    public function getIdville()
    {
        return $this->idville;
    }
}
