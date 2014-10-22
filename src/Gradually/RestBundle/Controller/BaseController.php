<?php

namespace Gradually\RestBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;


class BaseController extends FOSRestController implements ClassResourceInterface
{
    /**
	 * Get an Entity based on the Entity ID AND a secondary ID of an owning Entity
	 * @var string Repo of the Entity to find
     * @var integer $entityId
     * @var object $owningEntity
     */
    protected function getEntity($repo, $entityId, $owningEntity)
    {
		// establish the name of the $owningEntity and convert to lower case
		$name = strtolower(get_class($owningEntity));
		$name = substr(strrchr($name, "\\"), 1);

       	$entity = $this->getDoctrine()->getManager()->getRepository($repo)->findOneBy(
            array(
               	'id' => $entityId,
                $name => $owningEntity->getId(),
            )
        );

        return $entity;
    }
}