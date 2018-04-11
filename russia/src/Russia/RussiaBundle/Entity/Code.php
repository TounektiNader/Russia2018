<?php

namespace Russia\RussiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Code
 *
 * @ORM\Table(name="code")
 * @ORM\Entity
 */
class Code
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idCode", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcode;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=200, nullable=false)
     */
    private $code;


}

