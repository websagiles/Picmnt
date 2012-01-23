<?php
namespace SFM\PicmntBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SFM\PicmntBundle\Entity\Image;

class IndexController extends Controller
{

    public function indexAction()
    {
      if ($this->get('security.context')->isGranted('ROLE_USER')){
	return $this->redirect($this->generateUrl('secure_home'));
      }
      else{
	  
	  $em = $this->get('doctrine')->getEntityManager();

	  $lastImages = $em->getRepository('SFMPicmntBundle:Image')->getLastImages(10);

	  $mostCommentImages = $em->getRepository('SFMPicmntBundle:Image')->getMostComment(10);
	  
	  return $this->render('SFMPicmntBundle:Index:index.html.twig', array('lastImages'=>$lastImages, 'mostComments'=>$mostCommentImages));
      }
    }

    public function indexSecureAction()
    {
	return $this->redirect($this->generateUrl('img_show', Array("option"=>"random", "category"=>'all')));
    }

    public function langAction()
    {
	return $this->redirect($this->generateUrl('home'));
    }

}
