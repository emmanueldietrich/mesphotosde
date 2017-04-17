<?php
namespace ED\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Table(name="ed_user")
 * @ORM\Entity(repositoryClass="ED\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
	/**
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	
	/**
	 * One User has Many Albums
	 * @ORM\OneToMany(targetEntity="\ED\AlbumBundle\Entity\Album", mappedBy="owner")
	 */
	private $albums;
	
	
	/**
	 * One User has Many Images
	 * @ORM\OneToMany(targetEntity="\ED\AlbumBundle\Entity\Image", mappedBy="owner")
	 */
	private $images;
	
	
	
	public function __construct(){
		$this->albums = new ArrayCollection();
	}

    /**
     * Add album
     *
     * @param \ED\AlbumBundle\Entity\Album $album
     *
     * @return User
     */
    public function addAlbum(\ED\UserBundle\Entity\Album $album)
    {
        $this->albums[] = $album;

        return $this;
    }

    /**
     * Remove album
     *
     * @param \ED\AlbumBundle\Entity\Album $album
     */
    public function removeAlbum(\ED\UserBundle\Entity\Album $album)
    {
        $this->albums->removeElement($album);
    }

    /**
     * Get albums
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAlbums()
    {
        return $this->albums;
    }
}
