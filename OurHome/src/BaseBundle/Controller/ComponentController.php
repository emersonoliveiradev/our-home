<?php

namespace BaseBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class ComponentController extends Controller {
    
    /**
     * @Route("/componentes", name="component_index")
     * @Method("GET")
     *
     */
    public function indexAction(){
        return $this->render('component/index.html.twig');
    }
    
}




