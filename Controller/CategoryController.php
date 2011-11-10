<?php

namespace Gpupo\CamelSpiderBundle\Controller;

use Coregen\AdminGeneratorBundle\ORM\GeneratorController;
use Gpupo\CamelSpiderBundle\Generator\Category as Generator;

class CategoryController extends GeneratorController
{
    public function configure()
    {
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

    /**
     * Creates a new Tarefa entity.
     *
     */
    public function createAction()
    {
        // Configuring the Generator Controller
        $this->configure();

        $entityClass = $this->generator->class;
        $formType = $this->generator->form->type;

        $entity = new $entityClass();
        $form   = $this->createForm(new $formType(), $entity);

        $request = $this->getRequest();
        $form->bindRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getEntityManager();

            


            $manager->persist($entity);
            $manager->flush();

            if ($request->get('form_save_and_add') == 'true') {
                $this->get('session')->setFlash('success', 'The item was created successfully. Add a new one bellow.');
                return $this->redirect($this->generateUrl($this->generator->route . '_new'));
            } else {
                $this->get('session')->setFlash('success', 'The item was created successfully.');
                return $this->redirect($this->generateUrl($this->generator->route));
                //return $this->redirect($this->generateUrl($this->generator->route . '_show', array('id' => $entity->getId())));
            }

        }

        $this->get('session')->setFlash('error', 'An error ocurred while saving the item. Check the informed data.');
        return $this->renderView('new', array(
            'record' => $entity,
            'form'   => $form->createView()
        ));
    }

}
