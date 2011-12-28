<?php

namespace Gpupo\CamelSpiderBundle\Controller;

use Coregen\AdminGeneratorBundle\ORM\GeneratorController;
use Gpupo\CamelSpiderBundle\Generator\Subscription as Generator;
use Gpupo\CamelSpiderBundle\Entity\SubscriptionSchedule;
use Gpupo\CamelSpiderBundle\Entity\SubscriptionRepository;

use Symfony\Component\HttpFoundation\Response;
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


    public function indexAction()
    {
        // Configuring the Generator Controller
        $this->configure();

        // Defining filters
        $this->configureFilter();

        // Defining actual page
        $this->setPage($this->getRequest()->get('page', $this->getPage()));

        $pager = $this->getPager();

        $filterForm = $this->createFilterForm();
        if ($filterForm) {
            $filterForm = $filterForm->createView();
        }

        $stats = $this->getDoctrine()->getRepository('GpupoCamelSpiderBundle:Subscription')
                ->getStats($pager->getResults());


        $test = $this->getDoctrine()->getRepository('GpupoCamelSpiderBundle:Subscription')
                ->findByScheduledSubscriptions();

        return $this->render('GpupoCamelSpiderBundle:Subscription:listGrid.html.twig', array(
            'generator'   => $this->generator,
            'pager'       => $pager,
            'delete_form' => $this->createDeleteForm('fake')->createView(),
            'filter_form' => $filterForm,
            'stats'       => $stats,
        ));

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

    public function deleteAction($id)
    {
        // Configuring the Generator Controller
        $this->configure();

        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        $formData = $request->get('form');

        if (!isset($formData['subscription'])) {
            $this->get('session')->setFlash(
                    'error',
                    'To delete a subscription another subscription must be selected to move related data.'
                    );
            return $this->redirect($this->generateUrl($this->generator->route));
        } else if ($form->isValid()) {

            $manager = $this->getDoctrine()->getEntityManager();
            $entity = $manager->getRepository($this->generator->class)->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find entity.');
            }

            $manager->getRepository($this->generator->class)
                    ->removeAndMoveRelated($entity, $formData['subscription']);

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

        $captures = $manager->getRepository('FunparAdminBundle:Log')
                            ->findBy(
                                    array('type' => 'CAPTURE', 'subscription' => $entity->getId()),
                                    array('createdAt' => 'DESC'),
                                    3);

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('GpupoCamelSpiderBundle:Subscription:show.html.twig', array(
            'generator'   => $this->generator,
            'record'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'captures'    => $captures,
        ));
    }


    /**
     * Capture in real time
     *
     */
    public function captureAction($id)
    {
        $response = new Response();
        $response->headers->set('Content-Encoding', 'chunked');
        $response->headers->set('Transfer-Encoding', 'chunked');
        $response->headers->set('Content-Type', 'text/html');
        $response->headers->set('Connection', 'keep-alive');
        $response->sendHeaders();
        flush();
        ob_flush();
        echo "<html><head><title>Capture</title></head><body><pre>";
        $this->get('camel_spider.launcher')->checkUpdates($id);
        echo "\n\n\n\n<b>Done</b>.";
        echo "</pre></body></html>";

        return $response;
    }

    protected function getRepository()
    {
        $this->configure();
        $manager = $this->getDoctrine()->getEntityManager();
        $repository = $manager->getRepository($this->generator->model);

        return $repository;
    }

    protected function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->add('subscription', 'entity', array(
                                'class' => 'Gpupo\\CamelSpiderBundle\\Entity\\Subscription',
                                'query_builder' => function(SubscriptionRepository $er) {
                                    return $er->createQueryBuilder('s')
                                            ->add('orderBy', 's.name ASC');
                                },
                                'label' => 'Move related data to Subscription',
                                ))
            ->setAttribute('name', 'delete_form')
            ->getForm()
        ;
    }

}
