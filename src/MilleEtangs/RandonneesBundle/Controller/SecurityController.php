<?php

namespace MilleEtangs\RandonneesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\SecurityContext;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use MilleEtangs\RandonneesBundle\Document\Itineary;
use MilleEtangs\RandonneesBundle\Document\Article;

class SecurityController extends Controller 
{
	public function loginAction()
	{
		$form = $this->get('form.factory')->createNamed('', 'login');

		if ($error = $this->getErrorMessage()){
			$form->addError(new FormError($error));
		}

		return $this->render("MilleEtangsRandonneesBundle:Security:login.html.twig", array(
			'form' => $form->createView()
		));
	}

	public function loginCheckAction()
	{
		throw new \RuntimeException("This method should not be called");
	}

	public function logoutAction()
	{
		throw new \RuntimeException("This method should not be called");
	}

	protected function getErrorMessage()
    {
        $request = $this->getRequest();

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
            $request->getSession()->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        if ($error instanceof \Exception) {
            $error = $error->getMessage();
        }

        return $error;
    }

    public function menuAction()
    {
    	$itinearies = $this->get('doctrine_mongodb')
            ->getRepository('MilleEtangsRandonneesBundle:Itineary')
            ->findAll();

        $articles = $this->get('doctrine_mongodb')
            ->getRepository('MilleEtangsRandonneesBundle:Article')
            ->findAll();

    	return $this->render("MilleEtangsRandonneesBundle:Security:menu.html.twig", array(
    		'articles' => $articles,
            'itinearies' => $itinearies
    	));
    }

    public function createItinearyAction()
    {
    	$itineary = new Itineary();
    	$form =  $this->get('form.factory')->create("itineary", $itineary);

        if ("POST" === $this->getRequest()->getMethod()){
            $form->bind($this->getRequest());

            if($form->isValid()){
                $dm = $this->get('doctrine_mongodb')->getManager();
                $dm->persist($itineary);
                $dm->flush();

                $session = $this->getRequest()->getSession();
                $session->setFlash("succes", "Le parcours a bien été créé");

                return $this->redirect($this->generateUrl('admin_menu'));
            }
        }

        return $this->render("MilleEtangsRandonneesBundle:Security:form_itineary.html.twig", array(
            'form' => $form->createView()
        ));
    }

    public function updateItinearyAction($id = null)
    {
        if (!is_null($id)){
            $itineary = $this->get('doctrine_mongodb')
                ->getRepository("MilleEtangsRandonneesBundle:Itineary")
                ->findOneById($id)
            ;
            $form =  $this->get('form.factory')->create("itineary", $itineary);
        }

        if ("POST" === $this->getRequest()->getMethod()){
            $form->bind($this->getRequest());
            $session = $this->getRequest()->getSession();
            $dm = $this->get('doctrine_mongodb')->getManager();
            if(!is_null($this->getRequest()->get('delete'))){
                $dm->remove($itineary);
                $dm->flush();
                $session->setFlash("success", "Le parcours a bien été supprimé");
            }
            else{
                if($form->isValid()){
                    $dm->flush();
                    $session->setFlash("success", "Le parcours a bien été sauvegardé");
                }
            }

            return $this->redirect($this->generateUrl('admin_menu'));
        }

        return $this->render("MilleEtangsRandonneesBundle:Security:form_itineary.html.twig", array(
            'form' => $form->createView()
        ));
    }

    public function deleteRandonneeAction()
    {

    }

    public function createArticleAction()
    {
        $article = new Article();
        
        $form =  $this->get('form.factory')->create("article", $article);

        if ("POST" === $this->getRequest()->getMethod()){
            $form->bind($this->getRequest());

            if($form->isValid()){
                $em = $this->get('doctrine_mongodb')->getManager();
                $em->persist($article);
                $em->flush();

                $session = $this->getRequest()->getSession();
                $session->setFlash("succes", "L'article a bien été créée");

                return $this->redirect($this->generateUrl('admin_menu'));
            }
        }

        return $this->render("MilleEtangsRandonneesBundle:Security:form_article.html.twig", array(
            'form' => $form->createView()
        ));
    }

    public function updateArticleAction($id = null)
    {
        if (!is_null($id)) {
            $article = $this->get('doctrine_mongodb')
                ->getRepository('MilleEtangsRandonneesBundle:Article')
                ->findOneById($id)
            ;
        }

        $form =  $this->get('form.factory')->create("article", $article);

        if ("POST" === $this->getRequest()->getMethod()){
            $form->bind($this->getRequest());
            $session = $this->getRequest()->getSession();
            $em = $this->get('doctrine_mongodb')->getManager();
            if(!is_null($this->getRequest()->get('delete'))){
                $em->remove($article);
                $em->flush();
                $session->setFlash("success", "L'actualité a bien été supprimé");
            }
            else{
                if($form->isValid()){
                    $em->flush();
                    $session->setFlash("success", "L'actualité a bien été sauvegardée");
                }
            }
            
            return $this->redirect($this->generateUrl('admin_menu'));
        }

        return $this->render("MilleEtangsRandonneesBundle:Security:form_article.html.twig", array(
            'form' => $form->createView()
        ));
    }

    /*public function uploadPictureAction()
    {
        $image = new Image();
        $form =  $this->get('form.factory')->create("image", $image);

        if ("POST" === $this->getRequest()->getMethod()){
            $form->bind($this->getRequest());

            if($form->isValid()){
                $em = $this->get('doctrine')->getEntityManager();
                $em->persist($image);
                $em->flush();

                $session = $this->getRequest()->getSession();
                $session->setFlash("succes", "L'image a bien été uploadée : " . $image->getWebPath());

                return $this->redirect($this->generateUrl('admin_menu'));
            }
        }

        return $this->render("MilleEtangsRandonneesBundle:Security:form_image.html.twig", array(
            'form' => $form->createView()
        ));
    }*/
}
