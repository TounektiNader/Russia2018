<?php

namespace Russia\RussiaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DfTopic
 *
 * @ORM\Table(name="df_topic", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_7F5F9BD3989D9B62", columns={"slug"})}, indexes={@ORM\Index(name="IDX_7F5F9BD329CCBAD0", columns={"forum_id"}), @ORM\Index(name="IDX_7F5F9BD3A76ED395", columns={"user_id"})})
 * @ORM\Entity
 */
class DfTopic
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
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=false)
     */
    private $slug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="pinned", type="boolean", nullable=false)
     */
    private $pinned;

    /**
     * @var boolean
     *
     * @ORM\Column(name="resolved", type="boolean", nullable=false)
     */
    private $resolved;

    /**
     * @var boolean
     *
     * @ORM\Column(name="closed", type="boolean", nullable=false)
     */
    private $closed;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_post", type="datetime", nullable=true)
     */
    private $lastPost;

    /**
     * @var string
     *
     * @ORM\Column(name="image_url", type="string", length=255, nullable=true)
     */
    private $imageUrl;

    /**
     * @var \DfForum
     *
     * @ORM\ManyToOne(targetEntity="DfForum")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="forum_id", referencedColumnName="id")
     * })
     */
    private $forum;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;


}

