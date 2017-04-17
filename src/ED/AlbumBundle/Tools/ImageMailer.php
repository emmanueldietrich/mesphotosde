<?php

namespace ED\AlbumBundle\Tools;

use ED\AlbumBundle\Entity\Image;

class ImageMailer
{
  /**
   * @var \Swift_Mailer
   */
  private $mailer;

  public function __construct(\Swift_Mailer $mailer)
  {
    $this->mailer = $mailer;
  }

  public function sendNewNotification(Image $image)
  {
    $message = new \Swift_Message(
      'Image créée',
      'L\image a bien été créée.'
    );

    $message
      ->addTo('emmanuel.dietrich@gmail.com') // Ici bien sûr il faudrait un attribut "email", j'utilise "author" à la place
      ->addFrom($image->getOwner())
    ;

    $this->mailer->send($message);
  }
}
