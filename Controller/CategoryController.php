<?php

namespace Gpupo\CamelSpiderBundle\Controller;

use Coregen\AdminGeneratorBundle\ORM\GeneratorController;
use Gpupo\CamelSpiderBundle\Generator\Category as Generator;

class CategoryController extends GeneratorController
{
    public function configure()
    {
        //$generator = $this->get('coregen.generator');
        $generator = new Generator();
        $this->loadGenerator($generator);
    }

    protected function getRepository()
    {
        $this->configure();
        $manager = $this->getDoctrine()->getEntityManager();
        $repository = $manager->getRepository($this->generator->model);

        return $repository;
    }

    /**
     * make a sidebar menu component
     */
    public function getListAction($max = null)
    {
        $categories =  $this->getRepository()->findBy(array(), array('name' => 'ASC'));

        return $this->render('GpupoCamelSpiderBundle:Category:menu.html.twig', array('categories' => $categories));
    }


}
