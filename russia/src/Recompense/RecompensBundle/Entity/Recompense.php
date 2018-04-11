<?php

namespace Recompense\RecompensBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recompense
 *
 * @ORM\Table(name="recompense", indexes={@ORM\Index(name="c51", columns={"idCadeau"}), @ORM\Index(name="c52", columns={"username"})})
 * @ORM\Entity
 */
class Recompense
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idRecompense", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idrecompense;

    /**
     * @var \Cadeau
     *
     *
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Cadeau")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCadeau", referencedColumnName="id")
     * })
     */
    private $idcadeau;

    /**
     * @var \User
     *
     *
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Russia\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="username", referencedColumnName="id")
     * })
     */
    private $username;

    /**
     * @return \Cadeau
     */
    public function getIdcadeau()
    {
        return $this->idcadeau;
    }

    /**
     * @param \Cadeau $idcadeau
     */
    public function setIdcadeau($idcadeau)
    {
        $this->idcadeau = $idcadeau;
    }

    /**
     * @return \User
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param \User $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }


}

