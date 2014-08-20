<?php

namespace Acme\HelloBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Gradually\UserBundle\Entity\User;

class LoadUserData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $userSuper = new User();
        $userSuper->setUsername('super');

        $pwd = password_hash('superpwd', PASSWORD_BCRYPT, array('cost' => 12));
        $userSuper->setPassword($pwd);
        
        $userSuper->setFirstName('Super');
        $userSuper->setLastName('User');
        $userSuper->setIsActive(1);

        $manager->persist($userSuper);
        $manager->flush();
    }
}