<?php

namespace Acme\HelloBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Gradually\UserBundle\Entity\Role;
use Gradually\UserBundle\Entity\GraduateUser;
use Gradually\UserBundle\Entity\RecruiterUser;
use Gradually\UserBundle\Entity\AdminUser;
use Gradually\ProfileBundle\Entity\GraduateProfile;
use Gradually\ProfileBundle\Entity\RecruiterProfile;
use Gradually\UtilBundle\Entity\University;
use Gradually\UtilBundle\Entity\Degree;
use Gradually\UtilBundle\Entity\DegreeLevel;
use Gradually\GraduateBundle\Entity\Qualification;


class LoadUserData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        // UNIVERSITIES
        $uniM = new University();
        $uniM->setName('University of Manchester'); 

        $uniLi = new University();
        $uniLi->setName('University of Liverpool'); 

        $uniB = new University();
        $uniB->setName('University of Birmingham'); 

        $uniLo = new University();
        $uniLo->setName('University of London'); 

        // DEGREE LEVELS
        $ba = new DegreeLevel();
        $ba->setTitle('Bachelor of Art');
        $manager->persist($ba);

        $bsc = new DegreeLevel();
        $bsc->setTitle('Bachelor of Science');
        $manager->persist($bsc); 

        $ma = new DegreeLevel();
        $ma->setTitle('Master of Art');
        $manager->persist($ma);

        $msc = new DegreeLevel();
        $msc->setTitle('Master of Science');
        $manager->persist($msc);

        $phd = new DegreeLevel();
        $phd->setTitle('Doctor of Philosophy');
        $manager->persist($phd);

        // DEGREES
        $degCs = new Degree();
        $degCs->setTitle('Computer Science');
        $degCs->addLevel($bsc);
        $degCs->addLevel($msc);
        $degCs->addLevel($phd);
        $manager->persist($degCs);

        $degJ = new Degree();
        $degJ->setTitle('Journalism');
        $degJ->addLevel($ba);
        $degJ->addLevel($ma);
        $manager->persist($degJ);

        // CONNECT UNIS AND DEGREES
        $uniM->addDegree($degCs);
        $uniM->addDegree($degJ);
        $manager->persist($uniM);

        $uniLi->addDegree($degJ);
        $manager->persist($uniLi);

        $uniB->addDegree($degCs);
        $manager->persist($uniB);

        $uniLo->addDegree($degCs);
        $uniLo->addDegree($degJ);
        $manager->persist($uniLo);

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
        $userSuper = new AdminUser();
        $userSuper->setEmail('super@test.com');
        $userSuper->setPassword(password_hash('superpwd', PASSWORD_BCRYPT, array('cost' => 12)));
        $userSuper->addRole($roleSuper);
        $manager->persist($userSuper);
        
        $userAdmin = new AdminUser();
        $userAdmin->setEmail('admin@test.com');
        $userAdmin->setPassword(password_hash('adminpwd', PASSWORD_BCRYPT, array('cost' => 12)));
        $userAdmin->addRole($roleAdmin);
        $manager->persist($userAdmin);

        $g = new GraduateUser();
        $g->setEmail('grad@test.com');
        $g->setPassword(password_hash('gradpwd', PASSWORD_BCRYPT, array('cost' => 12)));
        $g->addRole($roleNormal);
        $q = new Qualification();
        $q->setUniversity($uniM);
        $q->setDegree($degCs);
        $q->setDegreeLevel($bsc);
        $q->setResult('2:1');
        $q->setYearAttained(new \DateTime('2012-10-08'));
        $q2 = new Qualification();
        $q2->setUniversity($uniM);
        $q2->setDegree($degCs);
        $q2->setDegreeLevel($msc);
        $q2->setResult('1');
        $q2->setYearAttained(new \DateTime('2013-10-08'));
        $p = new GraduateProfile();
        $p->setFirstName('Graduate');
        $p->setLastName('One');
        $g->setProfile($p);
        $q->setGraduate($p);
        $q2->setGraduate($p);
        $manager->persist($q);
        $manager->persist($q2);
        $manager->persist($p);
        $manager->persist($g);

        $g = new GraduateUser();
        $g->setEmail('grad2@test.com');
        $g->setPassword(password_hash('grad2pwd', PASSWORD_BCRYPT, array('cost' => 12)));
        $g->addRole($roleNormal);
        $q = new Qualification();
        $q->setUniversity($uniLo);
        $q->setDegree($degJ);
        $q->setDegreeLevel($ba);
        $q->setResult('2:1');
        $q->setYearAttained(new \DateTime('2012-10-08'));
        $p = new GraduateProfile();
        $p->setFirstName('Graduate');
        $p->setLastName('Two');
        $g->setProfile($p);
        $q->setGraduate($p);
        $manager->persist($q);
        $manager->persist($p);
        $manager->persist($g);
/*
        $userGraduate = new GraduateUser();
        $userGraduate->setUsername('graduate');
        $userGraduate->setPassword(password_hash('graduatepwd', PASSWORD_BCRYPT, array('cost' => 12)));
        $userGraduate->setFirstName('Graduate');
        $userGraduate->setLastName('User');
        $userGraduate->addRole($roleNormal);
        $userGraduate->setIsActive(1);
        $qual = new Qualification();
        $qual->setUniversity($uniM);
        $qual->setDegree($degCsBsc);
        $qual->setResult('2:1');
        $qual->setYearAttained(new \DateTime('2012-10-08'));
        $profile = new GraduateProfile();
        $profile->addQualification($qual);
        $qual->setGraduate($profile);
        $userGraduate->setProfile($profile);
        $manager->persist($qual);
        $manager->persist($profile);
        $manager->persist($userGraduate);

        $userRecruiter = new RecruiterUser();
        $userRecruiter->setUsername('recruiter');
        $userRecruiter->setPassword(password_hash('recruiterpwd', PASSWORD_BCRYPT, array('cost' => 12)));
        $userRecruiter->setFirstName('Recruiter');
        $userRecruiter->setLastName('User');
        $userRecruiter->addRole($roleNormal);
        $userRecruiter->setIsActive(1);
        $profile = new RecruiterProfile();
        $userRecruiter->setProfile($profile);
        $manager->persist($profile);
        $manager->persist($userRecruiter);

        // extra users
        $user = new GraduateUser();
        $user->setUsername('graduatetwo');
        $user->setPassword(password_hash('graduatetwopwd', PASSWORD_BCRYPT, array('cost' => 12)));
        $user->setFirstName('Graduate Two');
        $user->setLastName('User');
        $user->addRole($roleNormal);
        $qual = new Qualification();
        $qual->setUniversity($uniLo);
        $qual->setDegree($degJBa);
        $qual->setResult('First');
        $qual->setYearAttained(new \DateTime('2013-10-10'));
        $qual2 = new Qualification();
        $qual2->setUniversity($uniLo);
        $qual2->setDegree($degJMa);
        $qual2->setResult('2:2');
        $qual2->setYearAttained(new \DateTime('2014-10-10'));
        $profile = new GraduateProfile();
        $profile->addQualification($qual);
        $profile->addQualification($qual2);
        $qual->setGraduate($profile);
        $qual2->setGraduate($profile);
        $user->setProfile($profile);
        $manager->persist($qual);
        $manager->persist($qual2);
        $manager->persist($profile);
        $manager->persist($user);   
        

        $user = new RecruiterUser();
        $user->setUsername('recruitertwo');
        $user->setPassword(password_hash('recruitertwopwd', PASSWORD_BCRYPT, array('cost' => 12)));
        $user->setFirstName('Recruiter Two');
        $user->setLastName('User');
        $user->addRole($roleNormal);
        $profile = new RecruiterProfile();
        $user->setProfile($profile);
        $manager->persist($profile);
        $manager->persist($user); 

*/

        $manager->flush();
    }
}
