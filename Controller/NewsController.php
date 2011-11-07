<?php

namespace Gpupo\CamelSpiderBundle\Controller;

use Coregen\AdminGeneratorBundle\ORM\GeneratorController;
use Gpupo\CamelSpiderBundle\Generator\News as Generator;

class NewsController extends GeneratorController
{
    public function configure()
    {
        //$generator = $this->get('coregen.generator');
        $generator = new Generator();
        $this->loadGenerator($generator);
    }

    public function indexAction()
    {
        // Configuring the Generator Controller
        $this->configure();

        // Defining filters
        $this->configureFilter();

        // Defining actual page
        $this->setPage($this->getRequest()->get('page', $this->getPage()));

        $pager = $this->getPager();

        $deleteForm = $this->createDeleteForm('fake');

        return $this->render('GpupoCamelSpiderBundle:News:listGrid.html.twig', array(
            'pager'      => $pager,
            'delete_form' => $deleteForm->createView(),
            'generator'   => $this->generator,
        ));

    }


}
