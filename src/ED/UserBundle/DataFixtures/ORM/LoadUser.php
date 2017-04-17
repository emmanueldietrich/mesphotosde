<?php
namespace ED\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ED\UserBundle\Entity\User;

class LoadUser implements FixtureInterface
{
	public function load(ObjectManager $manager)
	{
		// Les noms d'utilisateurs à créer
		$listNames = array('Emmanuel', 'Alexandre', 'Marine', 'Anna');
		
		foreach ($listNames as $name) {
			// On crée l'utilisateur
			$user = new User;
			
			// Le nom d'utilisateur et le mot de passe sont identiques pour l'instant
			$user->setUsername($name);
			$user->setUsernameCanonical($name);
			$user->setPassword('YBqorDfqsiIuKL0RDpbPefFRSE2fYYpa9bG+1tySXVYE66zT4XXwvFDUY7Q9OFks0c6fJQ1sg35+oArmPb1R8g==');
			if($name == 'Emmanuel'){
				$user->setEmail('emmanuel.dietrich@gmail.com');
				$user->setEmailCanonical('emmanuel.dietrich@gmail.com');
			}
			else
			{	
				$user->setEmail($name.'@test.com');
				$user->setEmailCanonical($name.'@test.com');
			}
			$user->setSalt('F74pfmaeTijCTrIlJbYKnt4a6GKojOKmHxYuAao8Br4');
			$user->setRoles(array('ROLE_USER'));
			$user->setEnabled(1);
			// On le persiste
			$manager->persist($user);
		}
		
		// On déclenche l'enregistrement
		$manager->flush();
	}
}