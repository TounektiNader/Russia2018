<?php

namespace Russia\RussiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="Actualite")
 */
class Actualite
{

    /**
     * @var integer
     *
     * @ORM\Column(name="idactualite", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idactualite;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=200, nullable=true)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="texte", type="text", length=65535, nullable=true)
     */
    private $texte;

    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     */
    private $nomImage2;

    /**
     * @ORM\ManyToOne(targetEntity="Russia\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $username;

    /**
     * @Assert\File(maxSize="500k")
     */
    public $file2;

    /**
     * @return int
     */
    public function getIdactualite()
    {
        return $this->idactualite;
    }

    /**
     * @param int $idactualite
     */
    public function setIdactualite($idactualite)
    {
        $this->idactualite = $idactualite;
    }

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return string
     */
    public function getTexte()
    {
        return $this->texte;
    }

    /**
     * @param string $texte
     */
    public function setTexte($texte)
    {
        $this->texte = $texte;
    }

    /**
     * @return string
     */

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
    public function getWebPath2()
    {
        return null===$this->nomImage2 ? null : $this->getUploadDir2.'/'.$this->nomImage2;
    }
    protected  function getUploadRootDir2()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir2();
    }
    protected function getUploadDir2()
    {
        return 'images';
    }

    public function UploadProfilePicture2(){
        $this->file2->move($this->getUploadRootDir2(),$this->file2->getClientOriginalName());
        $this->nomImage2=$this->file2->getClientOriginalName();
        $this->file2=null;
    }

    /**
     * Set nomImage2
     * @param String $nomImage2
     * @return Categorie
     */
    public function setNomImage2($nomImage2)
    {
        $this->nomImage2==$nomImage2;

        return $this;
    }

    /**
     * Get nomImage2
     *
     * @return string
     */
    public function getNomImage2()
    {
        return $this->nomImage2;
    }

    public function __toString()
    {
        return $this->getTitre();
    }


}

