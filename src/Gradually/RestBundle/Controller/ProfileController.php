<?php

namespace Gradually\RestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Util\Codes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;

use Gradually\UtilBundle\Entity;
use Gradually\UtilBundle\Form;

class ProfileController extends BaseController
{
    /**
     * @var Request $request
     */
    public function cpostAction(Request $request, Entity\GraduateUser $graduate, Entity\Cv $cv)
    {
        //return new Response(json_encode(array('alex' => 'eves')));
        if(!$this->verifyEntity($graduate, $cv)){
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        $em = $this->getDoctrine()->getManager();

        $cv->setProfile($request->request->get('profile'));

        $em->persist($cv);
        $em->flush();

    	return new Response(json_encode($cv), Codes::HTTP_CREATED);
    }

    private function verifyEntity(Entity\GraduateUser $graduate, Entity\Cv $cv)
    {
        $entity = $this->getDoctrine()->getRepository('GraduallyUtilBundle:Cv')->findOneBy(
            array(
                'id' => $cv->getId(),
                'graduate' => $graduate->getId()
            )
        );

        return (bool) $entity;
    }
}