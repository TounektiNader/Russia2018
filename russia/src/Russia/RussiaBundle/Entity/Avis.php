<?php
/**
 * Created by PhpStorm.
 * User: serviceinfo
 * Date: 27/02/2018
 * Time: 21:32
 */

namespace Russia\RussiaBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="Avis")
 */

class Avis
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $rating;
    /**
     *
     * @ORM\Column(type="datetime")
     */
    private $date;
    /**
     * @ORM\ManyToOne(targetEntity="Russia\RussiaBundle\Entity\Actualite")
     * @ORM\JoinColumn(name="idactualite", referencedColumnName="idactualite")
     */
    private $actualite;
    /**
     * @ORM\ManyToOne(targetEntity="Russia\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="User_id", referencedColumnName="id")
     */

    private $user;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return \Actualite
     */
    public function getActualite()
    {
        return $this->actualite;
    }

    /**
     * @param \Actualite $actualite
     */
    public function setActualite($actualite)
    {
        $this->actualite = $actualite;
    }

    /**
     * @return \User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }



}