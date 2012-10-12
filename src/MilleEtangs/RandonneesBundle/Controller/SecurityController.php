<?php

namespace MilleEtangs\RandonneesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\SecurityContext;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use MilleEtangs\RandonneesBundle\Entity\Parcours;
use MilleEtangs\RandonneesBundle\Entity\Actualite;
use MilleEtangs\RandonneesBundle\Entity\Image;

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
    	$randonnees = $this->get('doctrine')
            ->getRepository('MilleEtangsRandonneesBundle:Parcours')
            ->findAll();

        $actualites = $this->get('doctrine')
            ->getRepository('MilleEtangsRandonneesBundle:Actualite')
            ->findAll();

    	return $this->render("MilleEtangsRandonneesBundle:Security:menu.html.twig", array(
    		'randonnees' => $randonnees,
            'actualites' => $actualites
    	));
    }

    public function createRandonneeAction()
    {
    	$randonnee = new Parcours();
    	$form =  $this->get('form.factory')->create("parcours", $randonnee);

        if ("POST" === $this->getRequest()->getMethod()){
            $form->bind($this->getRequest());

            if($form->isValid()){
                $em = $this->get('doctrine')->getEntityManager();
                $em->persist($randonnee);
                $em->flush();

                $session = $this->getRequest()->getSession();
                $session->setFlash("succes", "Le parcours a bien été créé");

                return $this->redirect($this->generateUrl('admin_menu'));
            }
        }

        return $this->render("MilleEtangsRandonneesBundle:Security:form_randonnee.html.twig", array(
            'form' => $form->createView()
        ));
    }

    public function updateRandonneeAction($id = null)
    {
        if (is_numeric($id)){
            $parcours = $this->get('doctrine')
                ->getRepository("MilleEtangsRandonneesBundle:Parcours")
                ->findOneById($id)
            ;
        }
        $form =  $this->get('form.factory')->create("parcours", $parcours);

        if ("POST" === $this->getRequest()->getMethod()){
            $form->bind($this->getRequest());

            if($form->isValid()){
                $em = $this->get('doctrine')->getEntityManager();
                $em->flush();

                $session = $this->getRequest()->getSession();
                $session->setFlash("succes", "Le parcours a bien été sauvegardé");

                return $this->redirect($this->generateUrl('admin_menu'));
            }
        }

        return $this->render("MilleEtangsRandonneesBundle:Security:form_randonnee.html.twig", array(
            'form' => $form->createView()
        ));
    }

    public function deleteRandonneeAction()
    {

    }

    public function createActualiteAction()
    {
        $actualite = new Actualite();
        
        $form =  $this->get('form.factory')->create("actualite", $actualite);

        if ("POST" === $this->getRequest()->getMethod()){
            $form->bind($this->getRequest());

            if($form->isValid()){
                $em = $this->get('doctrine')->getEntityManager();
                $em->persist($actualite);
                $em->flush();

                $session = $this->getRequest()->getSession();
                $session->setFlash("succes", "L'actualité a bien été créée");

                return $this->redirect($this->generateUrl('admin_menu'));
            }
        }

        return $this->render("MilleEtangsRandonneesBundle:Security:form_actualite.html.twig", array(
            'form' => $form->createView()
        ));
    }

    public function updateActualiteAction($id = null)
    {
        if (is_numeric($id)) {
            $actualite = $this->get('doctrine')
                ->getRepository('MilleEtangsRandonneesBundle:Actualite')
                ->findOneById($id)
            ;
        }

        if (!$actualite) {

        }

        $form =  $this->get('form.factory')->create("actualite", $actualite);

        if ("POST" === $this->getRequest()->getMethod()){
            $form->bind($this->getRequest());

            if($form->isValid()){
                $em = $this->get('doctrine')->getEntityManager();
                $em->flush();

                $session = $this->getRequest()->getSession();
                $session->setFlash("succes", "L'actualité a bien été sauvegardée");

                return $this->redirect($this->generateUrl('admin_menu'));
            }
        }

        return $this->render("MilleEtangsRandonneesBundle:Security:form_actualite.html.twig", array(
            'form' => $form->createView()
        ));
    }

    public function uploadPictureAction()
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
                $session->setFlash("succes", "L'image' a bien été uploadée : " . $image->getWebPath());

                return $this->redirect($this->generateUrl('admin_menu'));
            }
        }

        return $this->render("MilleEtangsRandonneesBundle:Security:form_image.html.twig", array(
            'form' => $form->createView()
        ));
    }
}