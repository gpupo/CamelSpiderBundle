<?php

namespace Gpupo\CamelSpiderBundle\Controller;

use Coregen\AdminGeneratorBundle\ORM\GeneratorController;
use Gpupo\CamelSpiderBundle\Generator\Category as Generator;
use Gpupo\CamelSpiderBundle\Entity\CategoryRepository;

class CategoryController extends GeneratorController
{
    public function configure()
    {
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

        return $this->render('GpupoCamelSpiderBundle:Category:list' . ucfirst($this->generator->list->layout . '.html.twig'), array(
            'pager'      => $pager,
            'delete_form' => $deleteForm->createView(),
            'generator'   => $this->generator,
        ));

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

        return $this->render('GpupoCamelSpiderBundle:Category:edit.html.twig', array(
            'generator'   => $this->generator,
            'record'      => $entity,
            'form'        => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function deleteAction($id)
    {
        // Configuring the Generator Controller
        $this->configure();

        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        $formData = $request->get('form');

        if (!isset($formData['category'])) {
            $this->get('session')->setFlash(
                    'error',
                    'To delete a category another category must be selected to move related data.'
                    );
            return $this->redirect($this->generateUrl($this->generator->route));
        } else if ($form->isValid()) {

            $manager = $this->getDoctrine()->getEntityManager();
            $entity = $manager->getRepository($this->generator->class)->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find entity.');
            }

            $manager->getRepository($this->generator->class)
                    ->removeAndMoveRelated($entity, $formData['category']);

            $this->get('session')->setFlash('success', 'The item was deleted successfully.');
            return $this->redirect($this->generateUrl($this->generator->route));
        } else {
            $this->get('session')->setFlash(
                    'error',
                    'An error ocurred while deleting the item.'
                    );
            return $this->redirect($this->generateUrl($this->generator->route));
        }

    }

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

        return $this->render('GpupoCamelSpiderBundle:Category:show.html.twig', array(
            'generator'   => $this->generator,
            'record'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    protected function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->add('category', 'entity', array(
                                'class' => 'Gpupo\\CamelSpiderBundle\\Entity\\Category',
                                'query_builder' => function(CategoryRepository $er) {
                                    return $er->createQueryBuilder('c')
                                            ->where('c.parent IS NOT NULL')
                                            ->add('orderBy', 'c.lft ASC');
                                },
                                'label' => 'Move related data to Category',
                                ))
            ->setAttribute('name', 'delete_form')
            ->getForm()
        ;
    }

}
