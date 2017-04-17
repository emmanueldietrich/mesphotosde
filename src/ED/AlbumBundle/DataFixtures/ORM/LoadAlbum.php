<?php

namespace ED\AlbumBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ED\AlbumBundle\Entity\Album;

class LoadAlbum extends AbstractFixture implements OrderedFixtureInterface
{
	// Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
	public function load(ObjectManager $manager)
	{
		// Liste des noms d'albums à créer
		$titles = array(
				'Vacances à Paris',
				'Vacances à Malte',
				'Week-end à Versailles',
				'Soirée Fin d\'année',
				'Anniversaire 30 ans'
		);
		
		foreach ($titles as $title) {
			// On crée l'album
			$album = new Album();
			$album->setTitle($title);
			$album->setSlug($title);
			$album->setDescription("Description blabla..");
			$user = $manager->getRepository('EDUserBundle:User')->findOneByUsername("Emmanuel");
			$album->setOwner($user);
			
			$images = $manager->getRepository('EDAlbumBundle:Image')->findAll();
			foreach ($images as $image)
			{
				$album->addImage($image);
			}
			
			// On le persiste
			$manager->persist($album);
		}
		
		$manager->flush();
	}
	
	public function getOrder()
	{
		// the order in which fixtures will be loaded
		// the lower the number, the sooner that this fixture is loaded
		return 20;
	}
}