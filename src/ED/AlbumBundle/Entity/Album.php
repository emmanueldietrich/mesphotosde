<?php

namespace ED\AlbumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Album
 *
 * @ORM\Table(name="ed_album")
 * @ORM\Entity(repositoryClass="ED\AlbumBundle\Repository\AlbumRepository")
 */
class Album
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updated;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"id","title"},style="camel")
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * 
     * @ORM\ManyToMany(targetEntity="ED\AlbumBundle\Entity\Image", cascade={"persist"})
     * @ORM\JoinTable(name="ed_album_image")
     */
    private $images;

    
    /**
     * @ORM\ManyToOne(targetEntity="ED\UserBundle\Entity\User", inversedBy="albums")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $owner;
    

    
    public function __construct()
    {
    	$this->created = new \Datetime();
    	$this->updated = $this->getCreated();
    	$this->images = new ArrayCollection();
    }
    
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Album
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Album
     */
    private function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function updateDate()
    {
    	$this->setUpdated(new \DateTime());
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Album
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
    	return $this->title;
    }
    
    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Album
     */
    public function setSlug($slug)
    {
    	$this->slug = $slug;
    	
    	return $this;
    }
    
    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
    	return $this->slug;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Album
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    
    /**
     * Get number of element in the album
     *
     * @return int
     */
    public function getNumberOfElement()
    {
    	return 3;
    }

    /**
     * Add image
     *
     * @param \ED\AlbumBundle\Entity\Image $image
     *
     * @return Album
     */
    public function addImage(\ED\AlbumBundle\Entity\Image $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \ED\AlbumBundle\Entity\Image $image
     */
    public function removeImage(\ED\AlbumBundle\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set owner
     *
     * @param \ED\UserBundle\Entity\User $owner
     *
     * @return Album
     */
    public function setOwner(\ED\UserBundle\Entity\User $owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }
}
