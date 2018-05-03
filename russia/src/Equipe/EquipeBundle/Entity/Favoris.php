<?php

namespace Equipe\EquipeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Favoris
 *
 * @ORM\Table(name="favoris", indexes={@ORM\Index(name="IDuser", columns={"IDuser"}), @ORM\Index(name="iDEquipe", columns={"iDEquipe"})})
 * @ORM\Entity(repositoryClass="Equipe\EquipeBundle\Repository\FavorisRepository")
 */
class Favoris
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Russia\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="\Russia\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IDuser", referencedColumnName="id")
     * })
     */
    private $iduser;

    /**
     * @var \Equipe
     *
     * @ORM\ManyToOne(targetEntity="Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="iDEquipe", referencedColumnName="idEquipe")
     * })
     */
    private $idequipe;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \User
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * @param \User $iduser
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;
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

