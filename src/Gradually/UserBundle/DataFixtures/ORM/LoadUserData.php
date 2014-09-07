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
use Gradually\JobBundle\Entity\Job;
use Gradually\PurchaseBundle\Entity\PurchaseOption;

class LoadUserData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {

        // UNIVERSITIES
	$universities = $this->createUniversities($manager);

        // DEGREE LEVELS
	$degreeLevels = $this->createDegreeLevels($manager);

        // DEGREES
	$degrees = $this->createDegrees($manager, $degreeLevels);

        // CONNECT UNIS AND DEGREES
	$this->connectUniversitiesToDegrees($manager, $universities, $degrees);

    	// ROLES
	$roles = $this->createRoles($manager);
        
	// PURCHASEOPTIONS
	$purchaseOptions = $this->createPurchaseOptions($manager);
	
    	// USERS
	$adminUsers = $this->createAdminUsers($manager, $roles['admin']);
	$superUsers = $this->createSuperUsers($manager, $roles['super']);
	$graduateUsers = $this->createGraduateUsers($manager, $roles['graduate'], $universities, $degrees, $degreeLevels);
	$recruiterUsers = $this->createRecruiterUsers($manager, $roles['recruiter']);

	// JOBS
	$jobs = $this->createJobs($manager, $recruiterUsers);
/*

        $r = new RecruiterUser();
        $r->setCompanyName("Recruiter One");
        $r->setEmail("recone@test.com");
        $r->setUsername("Recruiter One");
        $r->setPassword(password_hash('reconepwd', PASSWORD_BCRYPT, array('cost' => 12)));
        $r->addRole($roleRecruiter);
        $p = new RecruiterProfile();
        $p->setUser($r);
        $j = new Job();
        $j->setTitle('Recruiter One: Job One');
        $j->setDescription('Description for the job');
        $j->setSalaryFrom('20000');
        $j->setSalaryTo('25000');
        $j->setRecruiter($p);
        $manager->persist($p);
        $manager->persist($j);
        $manager->persist($r);
*/

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

    }

	protected function createUniversities($manager)
	{
		$return = array();

		// University of [A - z]
		for($i = 65; $i < 123; $i++){
			if($i > 90 && $i < 97){
				continue;
			}
			$entity = new University();
			$entity->setName(sprintf("University of %c", $i));
			$manager->persist($entity);
			$return[] = $entity;
		}

        	$manager->flush();
		return $return;
	}

	protected function createDegreeLevels($manager)
	{
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
	
        	$manager->flush();
		return array($ba, $bsc, $ma, $msc, $phd);
	}

	protected function createDegrees($manager, $innerEntities)
	{
		$return = array();

		// Degree name [A - Z]
		for($i = 65; $i < 91; $i++){
			$entity = new Degree();
			$entity->setTitle(sprintf("Degree name %c", $i));
			foreach($innerEntities as $innerEntity){
				$entity->addLevel($innerEntity);
			}	
			
			$manager->persist($entity);
			$return[] = $entity;
		}
		
        	$manager->flush();
		return $return;
	}

        protected function connectUniversitiesToDegrees($manager, $universities, $degrees)
	{
		foreach($universities as $u){
			foreach($degrees as $d){
				$u->addDegree($d);
			}	
			
			$manager->persist($u);
		}
        	
		$manager->flush();
	}

	protected function createRoles($manager)
	{
		$roleRecruiter = new Role();
		$roleRecruiter->setName('recruiter');
		$roleRecruiter->setRole('ROLE_RECRUITER');
		$manager->persist($roleRecruiter);

		$roleGraduate = new Role();
		$roleGraduate->setName('graduate');
		$roleGraduate->setRole('ROLE_GRADUATE');
		$manager->persist($roleGraduate);

		$roleAdmin = new Role();
		$roleAdmin->setName('admin');
		$roleAdmin->setRole('ROLE_ADMIN');
		$manager->persist($roleAdmin);

		$roleSuper = new Role();
		$roleSuper->setName('super');
		$roleSuper->setRole('ROLE_SUPER');
		$manager->persist($roleSuper);
	
		return array(
			'recruiter' => $roleRecruiter, 
			'graduate' => $roleGraduate, 
			'admin' => $roleAdmin, 
			'super' => $roleSuper
		);
        
		$manager->flush();
	}

	protected function createPurchaseOptions($manager)
	{
		$return = array();

	        $po = new PurchaseOption();
		$po->setReference('1JOB');
		$po->setPostingCredits(1);
		$po->setSearchCredits(0);
		$manager->persist($po); 
		$return[] = $po;

		$po = new PurchaseOption();
		$po->setReference('5JOB');
		$po->setPostingCredits(5);
		$po->setSearchCredits(0);
		$manager->persist($po); 
		$return[] = $po;

		$po = new PurchaseOption();
		$po->setReference('1SEARCH');
		$po->setPostingCredits(0);
		$po->setSearchCredits(1);
		$manager->persist($po);
		$return[] = $po;

		$po = new PurchaseOption();
		$po->setReference('5SEARCH');
		$po->setPostingCredits(0);
		$po->setSearchCredits(5);
		$manager->persist($po);
		$return[] = $po;

		$po = new PurchaseOption();
		$po->setReference('1JOB1SEARCH');
		$po->setPostingCredits(1);
		$po->setSearchCredits(1);
		$manager->persist($po); 
		$return[] = $po;

		$po = new PurchaseOption();
		$po->setReference('5JOB5SEARCH');
		$po->setPostingCredits(5);
		$po->setSearchCredits(5);
		$manager->persist($po);
		$return[] = $po;
		
        	$manager->flush();
		return $return;
	}

	protected function createAdminUsers($manager, $role)
	{
		$userAdmin = new AdminUser();
		$userAdmin->setEmail('admin@test.com');
		$userAdmin->setUsername('admin@test.com');
		$userAdmin->setPassword(password_hash('adminpwd', PASSWORD_BCRYPT, array('cost' => 12)));
		$userAdmin->addRole($role);
		$manager->persist($userAdmin);		
	
        	$manager->flush();
		return array($userAdmin);
	}

	protected function createSuperUsers($manager, $role)
	{
		$userSuper = new AdminUser();
		$userSuper->setEmail('super@test.com');
		$userSuper->setUsername('super@test.com');
		$userSuper->setPassword(password_hash('superpwd', PASSWORD_BCRYPT, array('cost' => 12)));
		$userSuper->addRole($role);
		$manager->persist($userSuper);	
	
        	$manager->flush();
		return array($userSuper);
	}

	protected function createGraduateUsers($manager, $role, $universities, $degrees, $degreeLevels)
	{
		$return = array();
		for($i = 1; $i < 2001; $i++){
			$g = new GraduateUser();
			$g->setFirstName(sprintf('Graduate %d', $i));
			$g->setLastName('Test');
			$g->setEmail(sprintf('grad%d@test.com', $i));
			$g->setUsername(sprintf('grad%d@test.com', $i));
			$g->setPassword(password_hash(sprintf('grad%dpwd', $i), PASSWORD_BCRYPT, array('cost' => 12)));
			$g->addRole($role);
		
			$p = new GraduateProfile();
			$p->setUser($g);
		
			// random number of qualifications
			$rand = rand(1,3);
			for($j = 0; $j < $rand; $j++){
				$q = new Qualification();
				// random uni
				$uniIndex = rand(0, count($universities)-1);
				$q->setUniversity($universities[$uniIndex]);
				// random degree
				$degreeIndex = rand(0, count($degrees)-1);
				$q->setDegree($degrees[$degreeIndex]);
				// random degree level
				$levelIndex = rand(0, count($degreeLevels)-1);
				$q->setDegreeLevel($degreeLevels[$levelIndex]);
				// random results
				switch(rand(0, 3)){
					case 0:
						$q->setResult('1');
						break;
					case 1:
						$q->setResult('2:1');
						break;
					case 2:
						$q->setResult('2:2');
						break;
					case 3:
						$q->setResult('3');
						break;
				}
				// random year
				$randYear = rand(10, 14);
				$year = sprintf('20%d', $randYear);
				$q->setYearAttained(new \DateTime(sprintf('%s-01-01', $year)));
				
				$q->setGraduate($p);	
				$manager->persist($q);
			}
			
			$manager->persist($p);
			$manager->persist($g);
		
			$return[] = $p;
		}
		
        	$manager->flush();
		return $return;
	}

	protected function createRecruiterUsers($manager, $role)
	{
		$return = array();
		
		for($i = 1; $i < 11; $i++){
			$r = new RecruiterUser();
			$r->setCompanyName(sprintf('Recruiter %d', $i));
			$r->setEmail(sprintf('rec%d@test.com', $i));
			$r->setUsername(sprintf('Recruiter %d', $i));
			$r->setPassword(password_hash(sprintf('rec%dpwd', $i), PASSWORD_BCRYPT, array('cost' => 12)));
			$r->addRole($role);
			$p = new RecruiterProfile();
			$p->setUser($r);
			$r->setProfile($p);	
			$manager->persist($p);
			$manager->persist($r);
			
			$return[] = $r;
		}
        
		$manager->flush();

		return $return;
	}

	protected function createJobs($manager, $recruiters)
	{
		$return = array();
		foreach($recruiters as $recruiter){
			for($i = 1; $i < 11; $i++){
				$j = new Job();
				$j->setTitle(sprintf('%s: Job %d', $recruiter->getCompanyName(), $i));
				$j->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. In consequat nunc vitae porta consectetur. Sed diam sapien, eleifend eu tempor vel, vehicula a sem. Nullam a tellus vehicula sem viverra volutpat. Nunc id est efficitur, auctor mi vel, tempus diam. Curabitur venenatis, eros sed scelerisque imperdiet, dui magna pretium nisi, at lobortis elit diam sit amet risus. Maecenas accumsan eleifend justo. Fusce sit amet libero ut ante auctor pulvinar. Aenean vitae felis at lacus facilisis interdum. Cras tempus tincidunt metus sit amet fringilla.

Ut vel ipsum eget felis dictum pharetra eu at purus. Sed lobortis tortor a nibh cursus suscipit. Maecenas pharetra rutrum semper. Pellentesque velit ex, dignissim eget arcu sit amet, vehicula blandit elit. Quisque at nisl sed tellus ornare semper at id nulla. Proin vitae consequat metus. Aliquam aliquet dolor ac ligula tempor suscipit. Mauris fringilla, odio vehicula facilisis varius, tortor urna malesuada nunc, non interdum ex diam ac mauris. Proin tincidunt porta hendrerit. Donec id efficitur libero, eget cursus lectus. Duis sagittis quis neque et pellentesque. Duis pellentesque, sem sit amet varius tincidunt, odio ex pretium sem, vitae facilisis dolor quam sed mauris. Integer id pulvinar enim, non tristique massa. Quisque porttitor ultricies lacus, vel tristique risus volutpat in. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed ligula massa, sollicitudin sed leo faucibus, ornare placerat tellus.

Sed pellentesque odio condimentum nisi lobortis ultricies. Aenean eget placerat felis, ut elementum ex. Nunc finibus vehicula volutpat. Nam sapien odio, tristique nec ultricies non, mollis quis est. Aenean ac sollicitudin leo. Vestibulum quam diam, dignissim in tristique quis, cursus ac orci. Vivamus sit amet bibendum lacus. Quisque at ex neque. Duis feugiat viverra mauris vitae tincidunt. Vestibulum consequat magna nulla, venenatis fringilla est pulvinar at. Donec imperdiet libero massa, in sollicitudin nisi luctus ut. Nulla vitae suscipit ex.

Etiam eget nisi laoreet, finibus nulla non, feugiat ligula. Curabitur id nunc eu felis lobortis convallis sed eu arcu. Maecenas facilisis eros massa, sit amet faucibus dolor aliquam ut. Integer scelerisque efficitur gravida. Vestibulum sit amet ex at dolor imperdiet malesuada. Aliquam non ligula ac nulla ullamcorper interdum a at nibh. Ut in nisl consectetur, vehicula sem at, accumsan dui.

Quisque nibh arcu, iaculis ac risus non, luctus pharetra massa. Suspendisse pretium nisi eu massa accumsan, tincidunt sollicitudin velit condimentum. Aenean dui lectus, pulvinar ac cursus vel, venenatis ac felis. Nam molestie at diam ac facilisis. Curabitur lectus metus, varius et imperdiet vitae, euismod nec velit. Sed sagittis augue sit amet nisl vehicula dictum quis ut velit. Phasellus cursus metus sed dui fermentum aliquet.');
				// random from 
				$fromRand = rand(10, 100);
				$from = sprintf('%d000', $fromRand);
				$j->setSalaryFrom($from);

				// to is 5 to 10 k> than from
				$to = sprintf('%d000', $fromRand + rand(5, 10));
				$j->setSalaryTo($to);
				$j->setRecruiter($recruiter->getProfile());

				$manager->persist($j);
				$return[] = $j;
			}
		}
        	$manager->flush();
		return $return;
	}
}
