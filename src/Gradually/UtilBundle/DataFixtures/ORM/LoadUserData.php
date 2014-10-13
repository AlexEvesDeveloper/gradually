<?php

namespace Gradually\UtilBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Gradually\UtilBundle\Entity\Role;
use Gradually\UtilBundle\Entity\GraduateUser;
use Gradually\UtilBundle\Entity\RecruiterUser;
use Gradually\UtilBundle\Entity\AdminUser;
use Gradually\UtilBundle\Entity\Job;
use Gradually\UtilBundle\Entity\Location;
use Gradually\UtilBundle\Classes\Doctrine\Point;

class LoadUserData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
		// LOCATIONS
		$locations = $this->createLocations($manager);

    	// ROLES
		$roles = $this->createRoles($manager);
	        		
    	// USERS
		$adminUsers = $this->createAdminUsers($manager, $roles['admin']);
		$superUsers = $this->createSuperUsers($manager, $roles['super']);
		//$graduateUsers = $this->createGraduateUsers($manager, $roles['graduate'], $universities, $degrees, $degreeLevels, $degreeResults);
		$recruiterUsers = $this->createRecruiterUsers($manager, $roles['recruiter']);
	
		// JOBS
		$jobs = $this->createJobs($manager, $recruiterUsers, $locations);
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

/*
	protected function createGraduateUsers($manager, $role, $universities, $degrees, $degreeLevels, $degreeResults)
	{
		$return = array();
		for($i = 1; $i < 11; $i++){
			$g = new GraduateUser();
			$g->setFirstName(sprintf('Graduate %d', $i));
			$g->setLastName('Test');
			$g->setEmail(sprintf('grad%d@test.com', $i));
			$g->setUsername(sprintf('grad%d@test.com', $i));
			$g->setPassword(password_hash(sprintf('grad%dpwd', $i), PASSWORD_BCRYPT, array('cost' => 12)));
			$g->addRole($role);
		
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
				switch(rand(0, 4)){
					case 0:
						$q->setResult($degreeResults[0]);
						break;
					case 1:
						$q->setResult($degreeResults[1]);
						break;
					case 2:
						$q->setResult($degreeResults[2]);
						break;
					case 3:
						$q->setResult($degreeResults[3]);
						break;
					case 4:
						$q->setResult($degreeResults[4]);
						break;
				}
				// random year
				$randYear = rand(2010, 2014);
				$q->setYearAttained($randYear);
				
				$q->setGraduate($g);	
				$manager->persist($q);
			}
			
			$manager->persist($g);
		
			$return[] = $g;
		}
		
        $manager->flush();
		return $return;
	}
*/
	protected function createRecruiterUsers($manager, $role)
	{
		$return = array();
		
		for($i = 1; $i < 2; $i++){
			$r = new RecruiterUser();
			$r->setCompanyName(sprintf('Recruiter %d', $i));
			$r->setEmail(sprintf('rec%d@test.com', $i));
			$r->setUsername(sprintf('Recruiter %d', $i));
			$r->setPassword(password_hash(sprintf('rec%dpwd', $i), PASSWORD_BCRYPT, array('cost' => 12)));
			$r->addRole($role);
	
			$manager->persist($r);
			
			$return[] = $r;
		}
        
		$manager->flush();

		return $return;
	}

	protected function createJobs($manager, $recruiters, $locations)
	{
		$return = array();
		$breakOut = 0;
		foreach($locations as $location){
			if(++$breakOut == 51){
				break;
			}
		    foreach($recruiters as $recruiter){
			for($i = 1; $i < 2; $i++){
				$j = new Job();
				$j->setTitle(sprintf('Recruiter %d: Job %d', rand(1, 5), rand(1,5)));
				$j->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. In consequat nunc vitae porta consectetur. Sed diam sapien, eleifend eu tempor vel, vehicula a sem. Nullam a tellus vehicula sem viverra volutpat. Nunc id est efficitur, auctor mi vel, tempus diam. Curabitur venenatis, eros sed scelerisque imperdiet, dui magna pretium nisi, at lobortis elit diam sit amet risus. Maecenas accumsan eleifend justo. Fusce sit amet libero ut ante auctor pulvinar. Aenean vitae felis at lacus facilisis interdum. Cras tempus tincidunt metus sit amet fringilla.');

				// random from 
				$fromRand = rand(10, 100);
				$from = sprintf('%d000', $fromRand);
				$j->setSalaryFrom($from);

				// to is 5 to 10 k> than from
				$to = sprintf('%d000', $fromRand + rand(5, 10));
				$j->setSalaryTo($to);
				$j->setRecruiter($recruiter);

				$j->setLocation($location);

				$j->setApplicationCount(rand(0,200));
				$j->setViewCount(rand(0,500));

				$manager->persist($j);
				$return[] = $j;
			}
  	 	    }
		}
        	$manager->flush();
		return $return;
	}

	protected function createLocations($manager)
	{
		$return = array();

		$row = 1;
		if(($handle = fopen(__DIR__.'/Uk-Postcodes-Towns.csv', 'r')) !== FALSE){
			while(($data = fgetcsv($handle, 1000, ',')) !== FALSE){
				// ignore first row
				if($row++ == 1){
					continue;
				}

				$postcode = $data[0];
				$point = new Point($data[2], $data[3]);
				$location = new Location();
				$location->setTown($data[1]);
				$location->setPostcode($postcode);
				$location->setPoint($point);
				
				$manager->persist($location);
				$return[] = $location;
			}
		}
		$manager->flush();
		return $return;
	}
}
