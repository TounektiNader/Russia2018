<?php

namespace Equipe\EquipeBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Joueurs
 *
 * @ORM\Table(name="joueurs", indexes={@ORM\Index(name="idEquipe", columns={"idEquipe"})})
 * @ORM\Entity
 */
class Joueurs
{
    /**
     * @var integer
     *
     * @ORM\Column(name="Idjoueur", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idjoueur;

    /**
     * @var string
     *
     * @ORM\Column(name="nomJoueur", type="string", length=200, nullable=false)
     */
    private $nomjoueur;

    /**
     * @var string
     *
     * @ORM\Column(name="prenomJoueur", type="string", length=200, nullable=false)
     */
    private $prenomjoueur;

    /**
     * @var string
     *
     * @ORM\Column(name="postion", type="string", length=200, nullable=false)
     */
    private $postion;

    /**
     * @var \Equipe
     *
     *
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idEquipe", referencedColumnName="idEquipe")
     * })
     */
    private $idequipe;

    /**
     * @return int
     */
    public function getIdjoueur()
    {
        return $this->idjoueur;
    }

    /**
     * @param int $idjoueur
     */
    public function setIdjoueur($idjoueur)
    {
        $this->idjoueur = $idjoueur;
    }

    /**
     * @return string
     */
    public function getNomjoueur()
    {
        return $this->nomjoueur;
    }

    /**
     * @param string $nomjoueur
     */
    public function setNomjoueur($nomjoueur)
    {
        $this->nomjoueur = $nomjoueur;
    }

    /**
     * @return string
     */
    public function getPrenomjoueur()
    {
        return $this->prenomjoueur;
    }

    /**
     * @param string $prenomjoueur
     */
    public function setPrenomjoueur($prenomjoueur)
    {
        $this->prenomjoueur = $prenomjoueur;
    }

    /**
     * @return string
     */
    public function getPostion()
    {
        return $this->postion;
    }

    /**
     * @param string $postion
     */
    public function setPostion($postion)
    {
        $this->postion = $postion;
    }

    /**
     * @return \Equipe
     */
    public function getIdequipe()
    {
        return $this->idequipe;
    }

    /**
     * @param \Equipe $idequipe
     */
    public function setIdequipe($idequipe)
    {
        $this->idequipe = $idequipe;
    }


}

