<?php
namespace ED\AlbumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ShelfController extends Controller
{
	public function albumAction()
	{
		$em = $this->getDoctrine()->getManager();
		
		$albums = $em->getRepository('EDAlbumBundle:Album')->findByOwner($this->getUser());
		
		$content = $this->get('templating')->render('EDAlbumBundle:Shelf:album.html.twig', array(
				'albums' => $albums,
		));
		
		return new Response($content);
	}
	
	public function imageAction()
	{
		$em = $this->getDoctrine()->getManager();
		
		$images = $em->getRepository('EDAlbumBundle:Image')->findByOwner($this->getUser());
		
		$content = $this->get('templating')->render('EDAlbumBundle:Shelf:image.html.twig', array(
				'images' => $images,
		));
		
		return new Response($content);
	}
}