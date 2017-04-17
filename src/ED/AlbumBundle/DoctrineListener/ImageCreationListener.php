<?php

namespace ED\AlbumBundle\DoctrineListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use ED\AlbumBundle\Tools\ImageMailer;
use ED\AlbumBundle\Entity\Image;

class ImageCreationListener
{
	/**
	 * @var ImageMailer
	 */
	private $imageMailer;
	
	public function __construct(ImageMailer $imageMailer)
	{
		$this->imageMailer= $imageMailer;
	}
	
	public function postPersist(LifecycleEventArgs $args)
	{
		$entity = $args->getObject();
		
		if (!$entity instanceof Image) {
			return;
		}
		
		$this->imageMailer->sendNewNotification($entity);
	}
}
