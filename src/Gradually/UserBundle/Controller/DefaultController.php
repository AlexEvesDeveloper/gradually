<?php

namespace Gradually\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * @Route("/user")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/login")
     * @Template()
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        // get the login error if there is one
        if($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)){
            $error = $request->attributes->get(SecurityContextInterface::AUTHENTICATION_ERROR);
        }elseif($session !== null && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)){
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        }else{
            $error = '';
        }

        // last credentials entered by the user
        $lastUsername = ($session === null) ? '' : $session->get(SecurityContextInterface::LAST_USERNAME);

        return array(
            'last_username' => $lastUsername,
            'error' => $error
        );
    }

    /**
     * @Route("/login_check")
     */
    public function loginCheckAction()
    {}

    /**
     * @Route("/logout")
     */
    public function logoutAction()
    {}
}
