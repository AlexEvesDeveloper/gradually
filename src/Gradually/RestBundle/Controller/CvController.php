<?php

namespace Gradually\RestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Gradually\UtilBundle\Entity;
use Gradually\UtilBundle\Form;

class CvController extends BaseController
{

    /**
     * @var Entity\GraduateUser $graduate
     *
     * @View()
     */
    public function cgetAction(Entity\GraduateUser $graduate)
    {
        return $this->getDoctrine()->getRepository('GraduallyUtilBundle:Cv')->findBy(
            array(
                'graduate' => $graduate->getId()
            )
        );
    }

    /**
     * @var Entity\GraduateUser $graduate
     * @var Entity\Cv
     *
     * @View()
     */
    public function getAction(Entity\GraduateUser $graduate, Entity\Cv $cv)
    {
        return $this->getDoctrine()->getRepository('GraduallyUtilBundle:Cv')->findOneBy(
            array(
                'id' => $cv->getId(),
                'graduate' => $graduate->getId(),
            )
        );
    }   
}