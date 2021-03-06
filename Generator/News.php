<?php

namespace Gpupo\CamelSpiderBundle\Generator;

use Coregen\AdminGeneratorBundle\Generator\Generator;

class News extends Generator
{
    protected function configure()
    {
        $actions = array();

        $fields  = array(
            'id'             => array('label' => 'ID'),
            'title'          => array(
                'label' => 'Title', 'size' => 'span12', 'help' => 'News Title'
            ),
            'category'       => array('label' => 'Category', 'size' => 'medium', 'help' => 'News Category'),
            'moderation'     => array('label' => 'Moderation', 'size' => 'medium', 'help' => 'Status of moderation', 'trans' => true),
            'moderation_date'=> array('label' => 'Moderation Date', 'date_format' => 'd/m/Y H:i:s'),
            'moderated_by'   => array('label' => 'Created By'),
            'moderationList' => array('label' => 'Moderação/ Data/ Usuário', 'list_partial' => 'GpupoCamelSpiderBundle:News:moderationList.html.twig'),
            'uri'            => array('label' => 'URI', 'size' => 'span12', 'help' => 'Full path to the news source'),
            'slug'           => array('label' => 'Slug', 'help' => 'URL short name'),
            'date'           => array('label' => 'Date', 'help' => 'News Date', 'class' => 'date span2', 'date_format' => 'd/m/Y'),
            'content'        => array(
                'label' => 'Content',
                'help' => 'The content of the news',
                'class' => 'richtext12-h1000',
                'raw' => true
            ),
            'subscription'   => array('label' => 'Subscription', 'help' => ''),
            'subscriptionList'  => array('label' => 'Fonte/ Criador', 'help' => '', 'list_partial' => 'GpupoCamelSpiderBundle:News:subscriptionList.html.twig'),
            'rawnews'        => array('label' => 'Raw News', 'help' => ''),
            'created_by'     => array('label' => 'Created By'),
            'created_at'     => array('label' => 'Created At', 'date_format' => 'd/m/Y H:i:s'),
            'updated_by'     => array('label' => 'Updated By'),
            'updated_at'     => array('label' => 'Updated At', 'date_format' => 'd/m/Y H:i:s'),
        );

        $list = array(
            'title'           => 'Listing News',
            'query_builder'   => 'optimizedListQueryBuilder',
            'display'         => array(
                'id',
                //'subscription',
                'subscriptionList',
                'title',
                'date',
                //'uri',
                //'slug',
                'moderationList',
                //'moderation',
                //'moderationDate',
                //'moderated_by',
                //'rawnews',
                //'created_by',
                //'created_at',
                //'updated_by',
                //'updated_at',
                ),
            # grid or stacked, default grid
            'layout'          => 'grid',
            'stackedTemplate' => '<h3>{{ record.name  }}</h3>' .
                                 '<p class="details_fixed">URI: <strong>{{ record.uri }}</strong></p>',
            'sort'            => array('date' =>  'DESC', 'id' => 'DESC'),
            'sort_fields'     => array('id', 'title', 'date'),
            'max_per_page'    => 30,
            'object_actions'  => array(),
            'batch_actions'   => array(
                'aprove' => array(
                    'label'  => 'Aprovar',
                    'success_message' => '%s item(ns) foram alterados para APROVADO.'
                ),
                'reject' => array(
                    'label'  => 'Rejeitar',
                    'success_message' => '%s item(ns) foram alterados para REJEITADO.'
                ),
                'delete' => array(
                    'label'  => 'Excluir',
                    'success_message' => '%s item(ns) foram excluídos com sucesso.'
                ),
            ),
        );

        $form = array(
            'type'   => "Gpupo\CamelSpiderBundle\Form\NewsType",
        );

        $edit = array(
            'title'   => "Editing News",
            'display' => array(
                //'id',
                'title',
                'uri',
                'date',
                'content',
                'subscription',
                'category',
                'moderation',
                //'slug',
                //'rawnews',
                //'created_by',
                //'created_at',
                //'updated_by',
                //'updated_at',
                ),
            'actions' => array(),
        );

        $new = array(
            'title'   => "New News",
            'display'         => array(
                //'id',
                'title',
                'uri',
                'date',
                'content',
                'subscription',
                'category',
                'moderation',
                //'slug',
                //'rawnews',
                //'created_by',
                //'created_at',
                //'updated_by',
                //'updated_at',
                ),
            'actions' => array(
                'save'         => true,
                'save_and_add' => false,
                'back_to_list' => true,
            ),
        );

        $show = array(
            'title'   => "Viewing News",
        );

        $filter = array(
            'title'   => "Filter",
            'fields' => array(
                'moderation' => array(
                    'type'    => 'choice',
                    'compare' => '=', // eq
                    'label'   => 'Moderation',
                    'options' => array('choices'=>array('PENDING'=>'PENDING','APROVED'=>'APROVED','REJECTED'=>'REJECTED'))
                    ),
                'date' => array(
                    'type'    => 'daterange',
                    //'compare' => 'between', // not used in date range
                    'label'   => 'Date',
                    ),
                'subscription' => array(
                    'type'    => 'entity',
                    'compare' => '=', // eq
                    'label'   => 'Subscription',
                    'options' => array(
                                'class' => 'Gpupo\\CamelSpiderBundle\\Entity\\Subscription',
                                'query_builder' => function(\Gpupo\CamelSpiderBundle\Entity\SubscriptionRepository $er) {
                                    return $er->createQueryBuilder('s')
                                            ->add('orderBy', 's.name ASC');
                                },
                        ),
                    ),
            ),
        );
        $this
            ->setClass('\Gpupo\CamelSpiderBundle\Entity\News')
            ->setModel('GpupoCamelSpiderBundle:News')
            ->setCoreTheme('CoregenThemeBootstrapBundle')
            ->setLayoutTheme('FunparAdminBundle')
            ->setRoute('news')
            ->setActions($actions)
            ->setList($list)
            ->setFields($fields)
            ->setForm($form)
            ->setEdit($edit)
            ->setNew($new)
            ->setShow($show)
            ->setFilter($filter)
            ;

    }
}
