<?php

namespace Russia\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;


/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User extends BaseUser

{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=200, nullable=false)
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=200, nullable=false)
     */
    protected $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=200, nullable=false)
     */
    protected $mdp;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=100, nullable=false)
     */
    protected $role;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=300, nullable=false)
     */
    protected $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=100, nullable=false)
     */
    protected $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="jeton", type="integer", nullable=false)
     */
    protected $jeton;

    /**
     * @var string
     *
     * @ORM\Column(name="nationalite", type="string", length=200, nullable=false)
     */
    protected $nationalite;

    /**
     * @var string
     *
     * @ORM\Column(name="num", type="string", length=1000, nullable=false)
     */
    protected $num;


    public function __construct()
    {
        parent::__construct();

        $this->setMdp('mdp');
        $this->setJeton(20);
        $this->setRole('role');
        $this->setStatus('status');
        $this->setMail('mail');


    }



    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string
     */
    public function getMdp()
    {
        return $this->mdp;
    }

    /**
     * @param string $mdp
     */
    public function setMdp($mdp)
    {
        $this->mdp = $mdp;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getJeton()
    {
        return $this->jeton;
    }

    /**
     * @param int $jeton
     */
    public function setJeton($jeton)
    {
        $this->jeton = $jeton;
    }

    /**
     * @return string
     */
    public function getNationalite()
    {
        return $this->nationalite;
    }

    /**
     * @param string $nationalite
     */
    public function setNationalite($nationalite)
    {
        $this->nationalite = $nationalite;
    }

    /**
     * @return string
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * @param string $num
     */
    public function setNum($num)
    {
        $this->num = $num;
    }

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



}

