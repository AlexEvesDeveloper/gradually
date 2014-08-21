<?php

namespace Gradually\ProfileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/profile")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/{id}")
     * @Template()
     */
    public function indexAction($id)
    {
        if($this->getUser()->getProfile()->getId() != $id){
            throw $this->createAccessDeniedException('Unable to access this page!');
        }

        return array('name' => $this->getUser()->getFirstName());
    }
}
