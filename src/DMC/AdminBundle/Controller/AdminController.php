<?php

namespace DMC\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * 
 * @Route("/admin")
 */
class AdminController extends Controller {

    /**
     * @Route("/")
     * @Template
     */
    public function indexAction() {                
        return array();
    }

}
