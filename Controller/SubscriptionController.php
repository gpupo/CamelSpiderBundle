<?php

namespace Gpupo\CamelSpiderBundle\Controller;

use Coregen\AdminGeneratorBundle\ORM\GeneratorController;
use Gpupo\CamelSpiderBundle\Generator\Subscription as Generator;
use Gpupo\CamelSpiderBundle\Entity\SubscriptionSchedule;

/**
 * Subscription Controller
 */
class SubscriptionController extends GeneratorController
{

    /**
     * Configure the generator
     *
     * @return void
     */
    public function configure()
    {
        //$generator = $this->get('coregen.generator');
        $generator = new Generator();
        $this->loadGenerator($generator);
    }


    /**
     * new Action
     *
     * @return Response
     */
    public function newAction()
    {
        // Configuring the Generator Controller
        $this->configure();

        $entityClass = $this->generator->class;
        $formType = $this->generator->form->type;

        $entity = new $entityClass();

        // Add three schedules by default
//        $entity->addSubscriptionSchedule(new SubscriptionSchedule());

        $form   = $this->createForm(new $formType(), $entity);

        return $this->render('GpupoCamelSpiderBundle:Subscription:new.html.twig', array(
            'generator' => $this->generator,
            'record'    => $entity,
            'form'      => $form->createView()
        ));

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

        $request = $this->getRequest();

        $form   = $this->createForm(new $formType(), $entity);

        $form->bindRequest($request);

        if ($form->isValid()) {
            $manager = $this->getDoctrine()->getEntityManager();
            $manager->persist($entity);
            $manager->flush();

            $this->get('funpar.logger')->doLog(
                    'SUBSCRIPTION_CREATE',
                    'Subscription created: ' . $entity->getName(),
                    $this->get('security.context')->getToken()->getUser(),
                    $entity
                    );

            $this->get('session')->setFlash('success', 'The item was created successfully.');
            return $this->redirect($this->generateUrl($this->generator->route));
        }

        $this->get('session')->setFlash('error', 'An error ocurred while saving the item. Check the informed data.');

        return $this->render('GpupoCamelSpiderBundle:Subscription:new.html.twig', array(
            'generator' => $this->generator,
            'record'    => $entity,
            'form'      => $form->createView()
        ));

    }

    /**
     * Displays a form to edit an existing Tarefa entity.
     *
     */
    public function editAction($id)
    {
        // Configuring the Generator Controller
        $this->configure();

        $manager = $this->getDoctrine()->getEntityManager();

        $entity = $manager->getRepository($this->generator->model)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entity.');
        }

        $formType = $this->generator->form->type;

        $editForm = $this->createForm(new $formType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        foreach ($this->generator->getHiddenFields('edit') as $fieldName) {
            $editForm->remove($fieldName);
        }

        return $this->render('GpupoCamelSpiderBundle:Subscription:edit.html.twig', array(
            'generator'   => $this->generator,
            'record'      => $entity,
            'form'        => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Tarefa entity.
     *
     */
    public function updateAction($id)
    {
        // Configuring the Generator Controller
        $this->configure();

        $manager = $this->getDoctrine()->getEntityManager();

        $entity = $manager->getRepository($this->generator->model)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find entity.');
        }

        $formType = $this->generator->form->type;

        $editForm = $this->createForm(new $formType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        foreach ($this->generator->getHiddenFields('edit') as $fieldName) {
            $editForm->remove($fieldName);
        }
        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $manager->persist($entity);
            $manager->flush();

            $this->get('session')->setFlash('success', 'The item was updated successfully.');
            return $this->redirect($this->generateUrl($this->generator->route));
        } else {
            $this->get('session')->setFlash('error', 'An error ocurred while saving the item. Check the informed data.');
            return $this->render('GpupoCamelSpiderBundle:Subscription:edit.html.twig', array(
                'generator'   => $this->generator,
                'record'      => $entity,
                'form'        => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));

        }

    }

    /**
     * Finds and displays a Tarefa entity.
     *
     */
    public function showAction($id)
    {
        // Configuring the Generator Controller
        $this->configure();

        $manager = $this->getDoctrine()->getEntityManager();

        $entity = $manager->getRepository($this->generator->model)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('GpupoCamelSpiderBundle:Subscription:show.html.twig', array(
            'generator'   => $this->generator,
            'record'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    protected function getRepository()
    {
        $this->configure();
        $manager = $this->getDoctrine()->getEntityManager();
        $repository = $manager->getRepository($this->generator->model);

        return $repository;
    }

}
