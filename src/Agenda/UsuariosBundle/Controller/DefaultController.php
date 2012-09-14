<?php

namespace Agenda\UsuariosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Security\Core\SecurityContext;

class DefaultController extends Controller
{
        /**
     * Muestra el formulario de login
     */
    public function loginAction()
    {
        $peticion = $this->getRequest();
        $sesion = $peticion->getSession();

        $error = $peticion->attributes->get(
            SecurityContext::AUTHENTICATION_ERROR,
            $sesion->get(SecurityContext::AUTHENTICATION_ERROR)
        );

        return $this->render('UsuariosBundle:Default:login.html.twig', array(
            'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
            'error'         => $error
        ));
    }
    public function indexAction()
    {
        $name="holallalaa";
        return $this->render('UsuariosBundle:Default:index.html.twig', array('name' => $name));
    }
}
