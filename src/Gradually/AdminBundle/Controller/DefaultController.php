<?php

namespace Gradually\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GraduallyAdminBundle:Default:index.html.twig');
    }
}
