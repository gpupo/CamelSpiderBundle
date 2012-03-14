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

        if ($filter_form = $this->createFilterForm()) {
            $filter_form = $filter_form->createView();
        }
        return $this->render('GpupoCamelSpiderBundle:News:listGrid.html.twig', array(
            'pager'       => $pager,
            'delete_form' => $this->createDeleteForm('fake')->createView(),
            'filter_form' => $filter_form,
            'generator'   => $this->generator,
        ));

    }

    /**
     * Creates a new News entity.
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

            // Moderation date defined automaticly
            if (in_array($entity->getModeration(), array('APROVED'=>'APROVED','REJECTED'=>'REJECTED'))) {
                $entity->setModerationDate(new \DateTime());
                $entity->setModeratedBy($this->get('security.context')->getToken()->getUser());
            }

            $manager->persist($entity);
            $manager->flush();

            $this->get('funpar.logger')->doLog(
                    'NEWS_CREATE',
                    'News created:  ' . $entity->getTitle(),
                    $this->get('security.context')->getToken()->getUser()
                    );

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

        return $this->render('GpupoCamelSpiderBundle:News:edit.html.twig', array(
            'record'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'generator'   => $this->generator,
        ));
    }

    public function updateAction($id)
    {
        // Configuring the Generator Controller
        $this->configure();

        $manager = $this->getDoctrine()->getEntityManager();

        $entity = $manager->getRepository($this->generator->model)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find entity.');
        }

        $oldModeration = $entity->getModeration();

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

            // Moderation date defined automaticly
            if (
                    $oldModeration != $entity->getModeration()
                    && in_array($entity->getModeration(), array('APROVED'=>'APROVED','REJECTED'=>'REJECTED'))
               ) {
                $entity->setModerationDate(new \DateTime());
                $entity->setModeratedBy($this->get('security.context')->getToken()->getUser());
            }




            $manager->flush();

            $this->get('session')->setFlash('success', 'The item was updated successfully.');
            return $this->redirect($this->generateUrl($this->generator->route));
            //return $this->redirect($this->generateUrl($this->generator->route . '_show', array('id' => $id)));
        } else {
            $this->get('session')->setFlash('error', 'An error ocurred while saving the item. Check the informed data.');
            return $this->renderView('edit', array(
                'record'      => $entity,
                'form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));

        }

    }



    /**
     * Batch Aprove
     *
     * @param array $ids An array of ids to batch process
     * @return View
     */
    protected function batchAprove($ids)
    {
        // Configuring the Generator Controller
        $this->configure();

        if (count($ids)) {

            try {
                $manager = $this->getDoctrine()->getEntityManager();
                $qb = $manager->createQueryBuilder($this->generator->class, 'e');
                $qb->update($this->generator->class, 'e')
                    ->andWhere($qb->expr()->in('e.id', $ids))
                    ->set('e.moderation', "'APROVED'")
                    ->getQuery()->execute();
            } catch (Exception $exc) {

                //echo $exc->getTraceAsString();
                $this->get('session')->setFlash(
                        'error',
                        'An error ocurred while executing the batch action.'
                        . '<br/>' . $exc->getTraceAsString()
                        );
                return $this->redirect($this->generateUrl($this->generator->route));
            }

            $batch_actions = $this->generator->list->batch_actions;
            $action = $batch_actions['aprove'];

            $message = $this->get('translator')->trans($action['success_message']);
            $message = sprintf($message, count($ids));

            $this->get('session')->setFlash('success', $message);
            return $this->redirect($this->generateUrl($this->generator->route));

        } else {
            $this->get('session')->setFlash('error','No itens selected to execute the batch action.');
            return $this->redirect($this->generateUrl($this->generator->route));
        }

    }

    /**
     * Batch Reject
     *
     * @param array $ids An array of ids to batch process
     * @return View
     */
    protected function batchReject($ids)
    {
        // Configuring the Generator Controller
        $this->configure();

        if (count($ids)) {

            try {
                $manager = $this->getDoctrine()->getEntityManager();
                $qb = $manager->createQueryBuilder($this->generator->class, 'e');
                $qb->update($this->generator->class, 'e')
                    ->andWhere($qb->expr()->in('e.id', $ids))
                    ->set('e.moderation', "'REJECTED'")
                    ->getQuery()->execute();
            } catch (Exception $exc) {

                //echo $exc->getTraceAsString();
                $this->get('session')->setFlash(
                        'error',
                        'An error ocurred while executing the batch action.'
                        . '<br/>' . $exc->getTraceAsString()
                        );
                return $this->redirect($this->generateUrl($this->generator->route));
            }

            $batch_actions = $this->generator->list->batch_actions;
            $action = $batch_actions['reject'];

            $message = $this->get('translator')->trans($action['success_message']);
            $message = sprintf($message, count($ids));

            $this->get('session')->setFlash('success', $message);
            return $this->redirect($this->generateUrl($this->generator->route));

        } else {
            $this->get('session')->setFlash('error','No itens selected to execute the batch action.');
            return $this->redirect($this->generateUrl($this->generator->route));
        }

    }

}
