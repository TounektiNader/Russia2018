<?php

namespace Russia\RussiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DfCategory
 *
 * @ORM\Table(name="df_category")
 * @ORM\Entity
 */
class DfCategory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="smallint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="disp_position", type="integer", nullable=false)
     */
    private $dispPosition;

    /**
     * @var string
     *
     * @ORM\Column(name="read_authorised_roles", type="string", length=255, nullable=true)
     */
    private $readAuthorisedRoles;


}

