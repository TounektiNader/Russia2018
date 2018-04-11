<?php

namespace Russia\RussiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DfPost
 *
 * @ORM\Table(name="df_post", indexes={@ORM\Index(name="IDX_FDB5B0441F55203D", columns={"topic_id"}), @ORM\Index(name="IDX_FDB5B0445BB66C05", columns={"poster_id"}), @ORM\Index(name="IDX_FDB5B04416FE72E1", columns={"updated_by"})})
 * @ORM\Entity
 */
class DfPost
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
     * @ORM\Column(name="content", type="text", nullable=false)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="updated_by", referencedColumnName="id")
     * })
     */
    private $updatedBy;

    /**
     * @var \DfTopic
     *
     * @ORM\ManyToOne(targetEntity="DfTopic")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="topic_id", referencedColumnName="id")
     * })
     */
    private $topic;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="poster_id", referencedColumnName="id")
     * })
     */
    private $poster;


}

