<?php
namespace ED\AlbumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use ED\AlbumBundle\Entity\Album;
use ED\AlbumBundle\Form\AlbumType;

class AlbumController extends Controller
{
	public function addAction(Request $request)
	{
		// Bien sûr, cette méthode devra réellement créer l'album
		$album = new Album();
		$form = $this->createForm(AlbumType::class,$album);
		
		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			
			$em = $this->getDoctrine()->getManager();
			$em->persist($album);
			$em->flush();
			
			// Alimentation flashbag
			$session = $request->getSession();
			$session->getFlashBag()->add('notice', 'L\'Album '.$album->getTitle().'a été créé');
			
			return $this->redirectToRoute('_ed_album_view', array(
					'id'  => $album->getId(),
			));
		}
		
		return $this->render('EDAlbumBundle:Album:add.html.twig', array(
				'form' => $form->createView(),
		));
	}
	
	public function viewAction($id, $slug='', Request $request)
	{		
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('EDAlbumBundle:Album');
		$album = $repository->find($id);
		
		if(null === $album)
		{
			throw new NotFoundHttpException("L'album n'existe pas");
		}
				
		return $this->render('EDAlbumBundle:Album:view.html.twig', array(
				'album'	=> $album,
		));
	}
	
	public function editAction($id, Request $request)
	{		
		$em = $this->getDoctrine()->getManager();
		$album = $em->getRepository('EDAlbumBundle:Album')->find($id);
		
		if(null === $album)
		{
			throw new NotFoundHttpException("L'album ".$id." n'existe pas.");
		}
		
		$form = $this->createForm(AlbumType::class, $album);
		
		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			
			$em->flush();
			$request->getSession()->getFlashBag()->add('notice', 'Album bien modifié');
			

			return $this->redirectToRoute('_ed_album_view', array(
					'id' => $album->getId(),
					//'slug'	=> $album->getSlug(),
			));
		}
		
		
		return $this->render('EDAlbumBundle:Album:edit.html.twig', array(
				'album' => $album,
				'form'	=> $form->createView(),
		));
	}
	
	public function deleteAction($id, Request $request)
	{		
		
		$em = $this->getDoctrine()->getManager();
		$album = $em->getRepository('EDAlbumBundle:Album')->find($id);
		
		if (null === $album) {
			throw new NotFoundHttpException("L'album ".$id." n'existe pas.");
		}
		
		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
		{
			$em->remove($album);
			$em->flush();
			
			// Alimentation flashbag
			$session = $request->getSession();
			$session->getFlashBag()->add('notice', 'L\'album a été supprimé');
			
			return $this->redirectToRoute('_ed_album_list');			
		}
		else
		{
			$form = $this->get('form.factory')->create();
			return $this->render('EDAlbumBundle:Album:delete.html.twig', array(
					'album' => $album,
					'form'   => $form->createView(),
			));
		}
	}
	
	public function menuAction($limit)
	{		
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('EDAlbumBundle:Album');
		$menuAlbums = $repository->getLastAlbums($limit, $this->getUser()->getId());
		
		return $this->render('EDAlbumBundle:Album:menu.html.twig', array(
				'menuAlbums' => $menuAlbums,
		));
	}
}