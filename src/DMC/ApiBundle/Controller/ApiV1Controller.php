<?php

namespace DMC\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * 
 * @Route("/api/v1")
 */
class ApiV1Controller extends Controller {
    
    
    /**
     * @Route("/users")
     * @Method({"GET"})
     * @Rest\View
     */
    public function getAllUsersAction() {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository("DMCUserBundle:User")->findAll();
        return array('users' => $users);
    }
    
}
