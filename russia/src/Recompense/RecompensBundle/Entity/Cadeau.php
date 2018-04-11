<?php

namespace Recompense\RecompensBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Beelab\TagBundle\Tag\TagInterface;
use Beelab\TagBundle\Tag\TaggableInterface;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Cadeau
 *
 * @ORM\Table(name="cadeau")
 * @ORM\Entity
 */
class Cadeau implements TaggableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idcadeau;

    /**
     * @var string
     *
     * @ORM\Column(name="Categorie", type="string", length=200, nullable=false)
     */
    private $categorie;

    /**
     * @var string
     *
     * @ORM\Column(name="Type", type="string", length=500, nullable=false)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="jeton", type="integer", nullable=false)
     */
    private $jeton;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=500, nullable=false)
     */
    private $image;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Tag",cascade={"persist"})
     */
    public $tags;

    // note: if you generated code with SensioGeneratorBundle, you need
    // to replace "Tag" with "TagInterface" where appropriate
    protected $tagsText;

    /**
     * @return mixed
     */
    public function getTagsText()
    {
        return $this->tagsText;
    }

    /**
     * @param mixed $tagsText
     */
    public function setTagsText($tagsText)
    {
        $this->tagsText = $tagsText;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function addTag(TagInterface $tag)
    {
        $this->tags[] = $tag;
    }

    /**
     * {@inheritdoc}
     */
    public function removeTag(TagInterface $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * {@inheritdoc}
     */
    public function hasTag(TagInterface $tag)
    {
        return $this->tags->contains($tag);
    }

    /**
     * {@inheritdoc}
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * {@inheritdoc}
     */
    public function getTagNames()
    {
        return empty($this->tagsText) ? [] : array_map('trim', explode(',', $this->tagsText));
    }


    /**
     * Get idcadeau
     *
     * @return integer
     */
    public function getIdcadeau()
    {
        return $this->idcadeau;
    }

    /**
     * Set cat�gorie
     *
     * @param string $cat�gorie
     *
     * @return Cadeau
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get cat�gorie
     *
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Cadeau
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set jeton
     *
     * @param integer $jeton
     *
     * @return Cadeau
     */
    public function setJeton($jeton)
    {
        $this->jeton = $jeton;

        return $this;
    }

    /**
     * Get jeton
     *
     * @return integer
     */
    public function getJeton()
    {
        return $this->jeton;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Cadeau
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return int
     */




}
