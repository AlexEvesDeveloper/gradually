<?php

namespace Acme\HelloBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Gradually\UserBundle\Entity\GraduateUser;
use Gradually\UserBundle\Entity\RecruiterUser;
use Gradually\UserBundle\Entity\AdminUser;
use Gradually\ProfileBundle\Entity\Profile;

class LoadUserData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $userSuper = new AdminUser();
        $userSuper->setUsername('super');
        $userSuper->setPassword(password_hash('superpwd', PASSWORD_BCRYPT, array('cost' => 12)));
        $userSuper->setFirstName('Super');
        $userSuper->setLastName('User');
        $userSuper->setIsActive(1);
        $profile = new Profile();
        $userSuper->setProfile($profile);
        $manager->persist($profile);
        $manager->persist($userSuper);
        
        $userAdmin = new AdminUser();
        $userAdmin->setUsername('admin');
        $userAdmin->setPassword(password_hash('adminpwd', PASSWORD_BCRYPT, array('cost' => 12)));
        $userAdmin->setFirstName('Admin');
        $userAdmin->setLastName('User');
        $userAdmin->setIsActive(1);
        $profile = new Profile();
        $userAdmin->setProfile($profile);
        $manager->persist($profile);
        $manager->persist($userAdmin);

        $userGraduate = new GraduateUser();
        $userGraduate->setUsername('graduate');
        $userGraduate->setPassword(password_hash('graduatepwd', PASSWORD_BCRYPT, array('cost' => 12)));
        $userGraduate->setFirstName('Graduate');
        $userGraduate->setLastName('User');
        $userGraduate->setIsActive(1);
        $profile = new Profile();
        $userGraduate->setProfile($profile);
        $manager->persist($profile);
        $manager->persist($userGraduate);

        $userRecruiter = new RecruiterUser();
        $userRecruiter->setUsername('recruiter');
        $userRecruiter->setPassword(password_hash('recruiterpwd', PASSWORD_BCRYPT, array('cost' => 12)));
        $userRecruiter->setFirstName('Recruiter');
        $userRecruiter->setLastName('User');
        $userRecruiter->setIsActive(1);
        $profile = new Profile();
        $userRecruiter->setProfile($profile);
        $manager->persist($profile);
        $manager->persist($userRecruiter);
        
        
        $manager->flush();
    }
}
