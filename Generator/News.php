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
            'title'          => array('label' => 'Title', 'size' => 'xlarge', 'help' => 'News Title'),
            'category'       => array('label' => 'Category', 'size' => 'medium', 'help' => 'News Category'),
            'moderation'     => array('label' => 'Moderation', 'size' => 'medium', 'help' => 'Status of moderation', 'trans' => true),
            'moderationDate' => array('label' => 'Moderation Date', 'date_format' => 'd/m/Y H:i:s'),
            'uri'            => array('label' => 'URI', 'size' => 'xxlarge', 'help' => 'Full path to the news source'),
            'slug'           => array('label' => 'Slug', 'help' => 'URL short name'),
            'date'           => array('label' => 'Date', 'help' => 'News Date', 'class' => 'date', 'date_format' => 'd/m/Y'),
            'content'        => array('label' => 'Content', 'help' => 'The content of the news', 'class' => 'richtext', 'raw' => true),
            'subscription'   => array('label' => 'Subscription', 'help' => ''),
            'rawnews'        => array('label' => 'Raw News', 'help' => ''),
            'created_by'     => array('label' => 'Created By'),
            'created_at'     => array('label' => 'Created At', 'date_format' => 'd/m/Y H:i:s'),
            'updated_by'     => array('label' => 'Updated By'),
            'updated_at'     => array('label' => 'Updated At', 'date_format' => 'd/m/Y H:i:s'),
        );

        $list = array(
            'title'           => 'Listing News',
            'query_builder'   => null,
            'display'         => array(
                'id',
                'subscription',
                'title',
                'date',
                //'uri',
                //'slug',
                'moderation',
                'moderationDate',
                //'rawnews',
                'created_by',
                //'created_at',
                //'updated_by',
                //'updated_at',
                ),
            # grid or stacked, default grid
            'layout'          => 'grid',
            'stackedTemplate' => '<h3>{{ record.name  }}</h3>' .
                                 '<p class="details_fixed">URI: <strong>{{ record.uri }}</strong></p>',
            'sort'            => array('createdAt' =>  'DESC', 'id' => 'DESC'),
            'max_per_page'    => 20,
            'object_actions'  => array(),
            'batch_actions'   => array(),
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
                    'name'    => 'moderation',
                    'type'    => 'choice',
                    'compare' => '=', // eq
                    'label'   => 'Moderation',
                    'options' => array('choices'=>array('PENDING'=>'PENDING','APROVED'=>'APROVED','REJECTED'=>'REJECTED'))
                ),
//                'createdAt' => array(
//                    'type'    => 'daterange',
//                    'compare' => 'between',
//                    'label'   => 'Created At',
//                ),
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
