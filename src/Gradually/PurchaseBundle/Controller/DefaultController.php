<?php

namespace Gradually\PurchaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gradually\PurchaseBundle\Entity\Transaction;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $options = $this->getDoctrine()->getRepository('GraduallyPurchaseBundle:PurchaseOption')->findAll();

        return array(
            'options' => $options
        );
    }

    /**
     * @Route("/{id}", requirements={"id":"\d+"})
     * @Template()
     */
    public function confirmAction(Request $request, $id)
    {
        // user must be logged in... 
        if(($user = $this->getUser()) == null){
            return $this->redirect($this->generateUrl('gradually_user_default_login')); 
        }
        
        $recruiter = $this->getDoctrine()->getRepository('GraduallyUserBundle:RecruiterUser')->find($user->getId()); 

        // ...and have ROLE_RECRUITER access
        if($recruiter === null && !$this->get('security.context')->isGranted('ROLE_RECRUITER') ){
            throw $this->createAccessDeniedException('Unable to access this page!');
        }

        $form = $this->createFormBuilder()
            ->add('save', 'submit', array('label' => 'Confirm purchase'))
            ->getForm();

        $form->handleRequest($request);


        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            
            // get the correct purchaseoption
            $purchaseOption = $em->getRepository('GraduallyPurchaseBundle:PurchaseOption')->find($id);
            
            // create a transaction
            $transaction = new Transaction();
            $transaction->setRecruiter($recruiter);
            $transaction->setOption($purchaseOption);
        
            // increment the credits for the recruiter
            $currentPostingCredits = $recruiter->getPostingCredits();
            $currentSearchCredits = $recruiter->getSearchCredits();
            $recruiter->setPostingCredits($currentPostingCredits += $purchaseOption->getPostingCredits());
            $recruiter->setSearchCredits($currentSearchCredits += $purchaseOption->getSearchCredits());

            $em->persist($transaction);
            $em->persist($recruiter);
            $em->flush();
        }

	    $dataPadded = $this->pkcs5_pad('Currency=GBP', 16);
	    //$crypt = $this->encryptFormData($dataPadded);

        return array(
            'recruiter' => $recruiter,
            'form' => $form->createView(),
            //'crypt' => $crypt
	    );
    }

    private function pkcs5_pad($input)
    {

        $blockSize = 16;
        $padd = "";

        // Pad input to an even block size boundary.
        $length = $blockSize - (strlen($input) % $blockSize);
        for ($i = 1; $i <= $length; $i++)
        {
            $padd .= chr($length);
        }

        return $input . $padd;
    }

    private function encryptFormData($input)
    {
	$key = 'VwOqLydQ4sveNRjY';
	$crypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $input, MCRYPT_MODE_CBC, $key);
	return "@" . strtoupper(bin2hex($crypt));
    }
}
