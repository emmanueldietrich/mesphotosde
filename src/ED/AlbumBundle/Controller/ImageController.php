<?php
namespace ED\AlbumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use ED\AlbumBundle\Entity\Image;
use ED\AlbumBundle\Form\ImageType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImageController extends Controller
{
	public function addAction(Request $request)
	{
		$image = new Image();
		$form = $this->createForm(ImageType::class,$image);
		
		if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
			if (isset($_FILES['images']) && is_array($_FILES['images'])) {
				foreach ($_FILES['images'] as $fileInfo) {
					
					$image->setOwner($this->getUser());
					
					$listener->addEntityFileInfo($file, $fileInfo);
					
					// You can set the file info directly with a FileInfoInterface object, like this:
					//
					// $listener->addEntityFileInfo($file, new FileInfoArray($fileInfo));
					//
					// Or create your own class which implements FileInfoInterface
					//
					// $listener->addEntityFileInfo($file, new MyOwnFileInfo($fileInfo));
					
					
					$em->persist($file);
				}
			}
			
			
			
			$em->flush();
			
			// Alimentation flashbag
			$session = $request->getSession();
			$session->getFlashBag()->add('info', 'L\'image a été créé');
			
			return $this->redirectToRoute('_ed_image_view', array(
					'id'  => $image->getId(),
			));
		}
		
		return $this->render('EDAlbumBundle:Image:add.html.twig', array(
				'image' => null,
				'form'	=> $form->createView(),
		));
	}
	
	public function viewAction($id, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('EDAlbumBundle:Image');
		$image = $repository->find($id);
		
		if(null === $image)
		{
			throw new NotFoundHttpException("L'image n'existe pas");
		}
		
		$repository = $em->getRepository('EDAlbumBundle:Album');
		$albums = $repository->getAlbumsFromOneImage($image, $this->getUser()->getId());
		
		$content = $this->get('templating')->render('EDAlbumBundle:Image:view.html.twig', array(
				'image'	=> $image,
				'relatedAlbums' => $albums,
		));
		
		return new Response($content);
	}
	
	public function editAction($id, Request $request)
	{
		/*
		// Ici, on récupérera l'album correspondante à $id
		$album = new Album();
		
		if ($request->isMethod('POST')) {
			$request->getSession()->getFlashBag()->add('notice', 'Album bien modifié');
			
			
			return $this->redirectToRoute('_ed_album_view', array(
					'album' => $album,
			));
		}
		
		return $this->render('EDAlbumBundle:Album:edit.html.twig', array(
				'album' => $album,
		));
		*/
	}
	
	public function deleteAction($id, Request $request)
	{
		/*
		$session = $request->getSession();
		
		// Alimentation flashbag
		$session->getFlashBag()->add('info', 'L\'album a été supprimé');
		
		return $this->redirectToRoute('_ed_album_list');
		*/
	}
}