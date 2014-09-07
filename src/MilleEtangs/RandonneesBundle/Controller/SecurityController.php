<?php

namespace MilleEtangs\RandonneesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\SecurityContext;
use MilleEtangs\RandonneesBundle\Document\Image;

class SecurityController extends Controller
{
    public function loginAction()
    {
        $form = $this->get('form.factory')->createNamed('', 'login');

        if ($error = $this->getErrorMessage()) {
            $form->addError(new FormError($error));
        }

        return $this->render("MilleEtangsRandonneesBundle:Security:login.html.twig", array(
            'form' => $form->createView()
        ));
    }

    public function loginCheckAction()
    {
        throw new \RuntimeException("This method should not be called");

        return $this->redirect($this->generateUrl('sonata_admin_dashboard'));
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

    public function uploadImageAction()
    {
        $image = new Image();
        $form =  $this->get('form.factory')->create("image", $image);

        if ("POST" === $this->getRequest()->getMethod()) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $dm = $this->get('doctrine_mongodb')->getManager();
                $upload = $this->getRequest()->files->get('image');
                $image = new Image();
                $image->setFile($upload['file']->getPathName());
                $image->setFilename($upload['file']->getClientOriginalName());
                $image->setMimeType($upload['file']->getMimeType());
                $dm->persist($image);
                $dm->flush();

                $this->get('session')->getFlashBag()->set(
                    "success",
                    "L'image a bien été uploadée : " . $image->getId()
                );

                return $this->redirect($this->generateUrl('admin_menu'));
            }
        }

        return $this->render("MilleEtangsRandonneesBundle:Security:form_image.html.twig", array(
            'form' => $form->createView()
        ));
    }
}
