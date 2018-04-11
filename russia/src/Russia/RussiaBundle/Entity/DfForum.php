<?php

namespace Russia\RussiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DfForum
 *
 * @ORM\Table(name="df_forum", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_6734FB05989D9B62", columns={"slug"})}, indexes={@ORM\Index(name="IDX_6734FB0512469DE2", columns={"category_id"})})
 * @ORM\Entity
 */
class DfForum
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=80, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=150, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=128, nullable=false)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="image_url", type="string", length=255, nullable=true)
     */
    private $imageUrl;

    /**
     * @var integer
     *
     * @ORM\Column(name="disp_position", type="integer", nullable=false)
     */
    private $dispPosition;

    /**
     * @var \DfCategory
     *
     * @ORM\ManyToOne(targetEntity="DfCategory")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;


}

