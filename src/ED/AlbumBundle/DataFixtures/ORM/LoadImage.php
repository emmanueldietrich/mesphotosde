<?php

namespace ED\AlbumBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ED\AlbumBundle\Entity\Image;
use ED\AlbumBundle\Entity\Album;

class LoadImage implements FixtureInterface
{
	// Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
	public function load(ObjectManager $manager)
	{
		// Liste des url d'image à créer
		$urls = array(
				'http://www.tao-restaurant.fr/wp-content/uploads/2013/03/plage20111102.jpg',
				'http://i-cms.linternaute.com/image_cms/750/10090998-les-plages-de-ksamil-dans-le-sud-de-l-albanie.jpg',
				'http://www.martinique.org/sites/martinique/files/plage_du_diamant_v1240_0.jpg',
				'http://ekladata.com/MYwvfgfu_XoP-ZvPUXPJv0GBDD4.jpg',
		);
		
		foreach ($urls as $url) {
			// On crée l'image
			$image = new Image();
			$image->setUrl($url);
			$image->setAlt('');
			$image->setPath('');
			$image->setName("test".date("ymd-his"));
			$image->setMimeType("test");
			$image->setSize(0);
			
			$user = $manager->getRepository('EDUserBundle:User')->findOneByUsername("Emmanuel");
			$image->setOwner($user);
			
			// On la persiste
			$manager->persist($image);
			
		}
		
		// On déclenche l'enregistrement de toutes les catégories
		$manager->flush();
	}
}