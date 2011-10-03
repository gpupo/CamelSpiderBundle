<?php

namespace Gpupo\CamelSpiderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('GpupoCamelSpiderBundle:Default:index.html.twig', array('name' => $name));
    }
}
