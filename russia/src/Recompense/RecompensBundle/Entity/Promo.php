<?php
/**
 * Created by PhpStorm.
 * User: 21650
 * Date: 29/03/2018
 * Time: 19:02
 */

namespace Recompense\RecompensBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Promo
 *
 * @ORM\Table(name="promo")
 * @ORM\Entity
 */

class Promo
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
     * @ORM\Column(name="coupon", type="string", length=255, nullable=false)
     */
    private $coupon;

    /**
     * @var integer
     *
     * @ORM\Column(name="promotion", type="integer", nullable=false)
     */
    private $promotion;
    /**
     * @var datetime
     *
     * @ORM\Column(name="expiration", type="datetime", nullable=false)
     */
    private $expiration;

    /**
     * @return datetime
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @param datetime $expiration
     */
    public function setExpiration($expiration)
    {
        $this->expiration = $expiration;
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

    /**
     * @return string
     */
    public function getCoupon()
    {
        return $this->coupon;
    }

    /**
     * @param string $coupon
     */
    public function setCoupon($coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * @return int
     */
    public function getPromotion()
    {
        return $this->promotion;
    }

    /**
     * @param int $promotion
     */
    public function setPromotion($promotion)
    {
        $this->promotion = $promotion;
    }


}