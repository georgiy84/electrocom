<?php

// src/AppBundle/Controller/LoginController.php

namespace Core\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller {

    public function loginAction() {


        $authenticationUtils = $this->get('security.authentication_utils');
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

//        dump($error);
//        die();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $account = 0;
        return $this->render(
                        'CoreUserBundle:Users:login.html.twig', array(
                    // last username entered by the user
                    'last_username' => $lastUsername,
                    'error' => $error,
                    'account' => $account,
                        )
        );
    }

    public function logoutAction() {
        throw new \Exception('this should not be reached!');
    }

}
