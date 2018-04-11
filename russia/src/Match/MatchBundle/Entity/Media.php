<?php
/**
 * Created by PhpStorm.
 * User: Nader
 * Date: 09/04/2018
 * Time: 22:55
 */

namespace Match\MatchBundle\Entity;



use Doctrine\ORM\Mapping as ORM;

/**
 * Bet
 *
 * @ORM\Table(name="media")
 * @ORM\Entity
 */
class Media

{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


      /**
       * @var string
       *
       * @ORM\Column(name="natio", type="string", length=255, nullable=false)
       * */
    private $natio;


    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     * */
    private $url;

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
     * @return string
     */
    public function getNatio()
    {
        return $this->natio;
    }

    /**
     * @param string $natio
     */
    public function setNatio($natio)
    {
        $this->natio = $natio;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }



}