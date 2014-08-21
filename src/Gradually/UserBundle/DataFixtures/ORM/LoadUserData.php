<?php

namespace Acme\HelloBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Gradually\UserBundle\Entity\User;
use Gradually\UserBundle\Entity\Role;

class LoadUserData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
    	// ROLES
    	$roleNormal = new Role();
    	$roleNormal->setName('normal');
    	$roleNormal->setRole('ROLE_NORMAL');
    	$manager->persist($roleNormal);

    	$roleAdmin = new Role();
    	$roleAdmin->setName('admin');
    	$roleAdmin->setRole('ROLE_ADMIN');
    	$manager->persist($roleAdmin);

    	$roleSuper = new Role();
    	$roleSuper->setName('super');
    	$roleSuper->setRole('ROLE_SUPER');
    	$manager->persist($roleSuper);

    	// USERS
        $userNormal = new User();
        $userNormal->setUsername('normal');
        $userNormal->setPassword(password_hash('normalpwd', PASSWORD_BCRYPT, array('cost' => 12)));
        $userNormal->setFirstName('Normal');
        $userNormal->setLastName('User');
        $userNormal->addRole($roleNormal);
        $manager->persist($userNormal);

        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $userAdmin->setPassword(password_hash('adminpwd', PASSWORD_BCRYPT, array('cost' => 12)));
        $userAdmin->setFirstName('Admin');
        $userAdmin->setLastName('User');
        $userAdmin->addRole($roleAdmin);
        $manager->persist($userAdmin);

        $userSuper = new User();
        $userSuper->setUsername('super');
        $userSuper->setPassword(password_hash('superpwd', PASSWORD_BCRYPT, array('cost' => 12)));
        $userSuper->setFirstName('Super');
        $userSuper->setLastName('User');
        $userSuper->addRole($roleSuper);
        $manager->persist($userSuper);

        $manager->flush();
    }
}