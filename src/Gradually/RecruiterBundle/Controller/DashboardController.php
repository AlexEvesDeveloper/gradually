<?php

namespace Gradually\RecruiterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DashboardController extends Controller
{
    /**
     * @Template()
     */
    public function jobsWidgetAction()
    {
        $repo = $this->getDoctrine()->getRepository('GraduallyUtilBundle:Job');
        $userId = $this->getUser()->getId();

        $mostRecent = $repo->findMostRecentJobs($userId, 5);
        $mostViewed = $repo->findMostViewedJobs($userId, 5);
        $mostApplied = $repo->findMostAppliedJobs($userId, 5);

        return array(
            'mostRecent' => $mostRecent,
            'mostViewed' => $mostViewed,
            'mostApplied' => $mostApplied,
        );
    }

    /**
     * @Template()
     */
    public function applicationsWidgetAction()
    {
        $repo = $this->getDoctrine()->getRepository('GraduallyUtilBundle:Application');
        $user = $this->getUser();
        $userId = $user->getId();

        $applicationCount = $repo->findApplicationCountForARecruiter($userId);
        $mostRecent = $repo->findMostRecentApplications($userId, 5);
        // most relevant
        // most local

        return array(
            'hasApplications' => count($mostRecent),
            'mostRecent' => $mostRecent,
            'jobs' => $this->getDoctrine()->getRepository('GraduallyUtilBundle:Job')->findAllJobsWithNewApplicationsForThisRecruiter($userId) 
            //'jobs' => $this->getDoctrine()->getRepository('GraduallyUtilBundle:Job')->findBy(array('recruiter' => $userId), array('id' => 'DESC'))
        );
    }
}