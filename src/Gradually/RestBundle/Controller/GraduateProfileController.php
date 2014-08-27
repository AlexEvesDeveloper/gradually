<?php

namespace Gradually\RestBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


use Gradually\ProfileBundle\Entity\GraduateProfile;
use Gradually\ProfileBundle\Form\GraduateProfileType;


class GraduateProfileController extends FOSRestController implements ClassResourceInterface
{
     /**
      * @return array
      *
      * @View()
      */
     public function cgetAction()
     {
        $profiles = $this->getDoctrine()->getManager()->getRepository('GraduallyProfileBundle:GraduateProfile')->findAll();

        return $profiles;
     }


     /**
      * @var GraduateProfile $profile
      * @return array
      *
      * @View()
      */
     public function getAction(GraduateProfile $profile)
     {
        return $profile;
     }
}