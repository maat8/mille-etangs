<?php

namespace MilleEtangs\RandonneesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\SecurityContext;

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
        return $this->redirect('login');
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
}
